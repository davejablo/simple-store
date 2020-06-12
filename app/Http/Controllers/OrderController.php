<?php

namespace App\Http\Controllers;

use App\Document;
use App\Http\Repositories\OrderRepository;
use App\Http\Requests\Order\StoreOrderRequest;
use App\Http\Requests\Order\UpdateOrderRequest;
use App\Http\Resources\DocumentResource;
use App\Http\Resources\OrderResource;
use App\Http\Resources\StoreDocumentRequest;
use App\Order;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Lcobucci\JWT\Parsing\Encoder;
use Spatie\ArrayToXml\ArrayToXml;

class OrderController extends Controller
{
    protected $orderRepository;
    protected $auth;
    const RESULTS = [5, 15, 25, 50, 75, 100];

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }


    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('viewAny',Order::class);
        if (request()->query())
        {
            request()->validate([
                'results' => [
                    'required',
                    'integer',
                    Rule::in(self::RESULTS)
                ]
            ]);
            $results = request()->get('results');
            return OrderResource::collection($this->orderRepository->getOrders($results));
        }
        else
            return OrderResource::collection($this->orderRepository->getAllOrders());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * @param StoreOrderRequest $request
     */
    public function store(StoreOrderRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * @param UpdateOrderRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateOrderRequest $request, $id)
    {
        $authUser = $this->auth->user();
        $this->authorize('update', $authUser->order, Order::class);
        $updatedOrder = new OrderResource($this->orderRepository->updateAndReturnOrder($request, $id));

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'message' => 'Order updated',
            'data' => [
                'item' => $updatedOrder,
            ]
        ], 200);
    }

    /**
     * @param Order $order
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Order $order)
    {
        $authUser = $this->auth->user();
        $this->authorize('delete', $authUser->order, Order::class);
        $this->orderRepository->destroyOrder($order);
        return response()->json([
            'code' => 200,
            'status' => 'success',
            'message' => 'Order deleted',
        ], 200);
        //
    }

    /**
     * Download the specified resource as PDF file
     *
     * @param \App\Order $order
     * @return \Illuminate\Http\JsonResponse
     */
    public function downloadPDF(Order $order)
    {
        $orderFromDB = Order::find($order->id);
        $products = $orderFromDB->products();
        $orderToReturn = new OrderResource($orderFromDB->with('products'));
        $pdfInvoice = PDF::loadView('pdf', compact('orderToReturn', 'products'));

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'message' => 'PDF invoice',
            'data' => [
                'item' => $orderToReturn,
                'pdf' => $pdfInvoice->download('invoice.pdf'),
            ]
        ], 200);
    }

    /**
     * Encode specified resource in EDI format and save it
     *
     * @param Order $order
     * @return \Illuminate\Http\JsonResponse
     */
    public function toEDI(Order $order)
    {
        $orderToEncode = new OrderResource(Order::find($order->id)->with('products'));
        $ediEncoder = new Encoder();
        $ediEncoder ->encode($orderToEncode, $wrap = true);
        $documentPath = $ediEncoder->get()->store('uploads/documents', 'public');

        $EDIdocument = Document::create([
            'name' => $orderToEncode->getRouteKeyName(),
            'description' => 'EDI document',
            'document' => $documentPath,
        ]);

        return response()->json([
            'code' => 200,
            'status' => 'Success',
            'message' => 'Invoice EDI format',
            'data' => [
                'item' => $orderToEncode,
                'EDI' => $EDIdocument,
            ]
        ], 200);
    }

    /**
     * Download specified resource in XML format
     *
     * @param Order $order
     * @return \Illuminate\Http\JsonResponse
     */
    public function downloadXML(Order $order)
    {
        $orderToEncode = Order::find($order->id)->with('products');
        $OrderXml = ArrayToXml::convert($orderToEncode);
        if ($OrderXml){
            return response()->json([
                'code' => 200,
                'status' => 'Success',
                'message' => 'Invoice XML format',
                'data' => [
                    'item' => $OrderXml,
                ]
            ], 200);
        }
        else
            return response()->json([
                'code' => 404,
                'status' => 'Error',
                'message' => 'Invoice EDI format',
            ], 404);
    }

    /**
     * Upload an XML document and save it
     *
     * @param StoreDocumentRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadXML(StoreDocumentRequest $request)
    {
        $documentPath = $request->file('document')->store('uploads/documents', 'public');
        $document = Document::create([
            'document_id' => $request->order_id,
            'name' => $request->file('document')->getClientOriginalName(),
            'description' => $request->description,
            'document' => $documentPath,
        ]);

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'message' => 'XML uploaded !',
            'data' => [
                'item' => new DocumentResource($document),
            ]
        ], 200);

    }
}
