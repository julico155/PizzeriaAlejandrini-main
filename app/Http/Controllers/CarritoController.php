<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Pizza;
use App\Models\Pedido;
use Illuminate\Http\Request;
use App\Models\DetallePedido;
use GuzzleHttp\Client;

class CarritoController extends Controller
{
    public function index(){
        $pedido = Pedido::where('cliente_id', auth()->user()->id)->where('pedido_estado_id', '1')->first();
        if($pedido){
            $detalles = DetallePedido::where('pedido_id', $pedido->id)->get()->map(function($detalle){
                return [
                    'id' => $detalle->id,
                    'pedido_id' => $detalle->pedido_id,
                    'pizza_id' => $detalle->pizza_id,
                    'cantidad' => $detalle->cantidad,
                    'subtotal' => $detalle->subtotal,
                    'pizza' => $detalle->pizza
                ];
            });
            $total = $detalles->sum('subtotal');
            return Inertia::render('Carrito/Index',[
                'pedido' => $pedido,
                'detalles' => $detalles,
                'total' => $total
            ]);
        }


        return Inertia::render('Carrito/Index',[
            'pedido' => null,
            'detalles' => null,
            'total' => 0
        ]);
    }

    public function ConsultarEstado(Request $request)
    {
        $lnTransaccion = $request->tnTransaccion;
        
        $loClientEstado = new Client();

        $lcUrlEstadoTransaccion = "https://serviciostigomoney.pagofacil.com.bo/api/servicio/consultartransaccion";

        $laHeaderEstadoTransaccion = [
            'Accept' => 'application/json'
        ];

        $laBodyEstadoTransaccion = [
            "TransaccionDePago" => $lnTransaccion
        ];

        $loEstadoTransaccion = $loClientEstado->post($lcUrlEstadoTransaccion, [
            'headers' => $laHeaderEstadoTransaccion,
            'json' => $laBodyEstadoTransaccion
        ]);

        $laResultEstadoTransaccion = json_decode($loEstadoTransaccion->getBody()->getContents());
         return response()->json(['message' => $laResultEstadoTransaccion]);
        

        $texto = $laResultEstadoTransaccion->values->messageEstado;

        return response()->json(['message' => $texto]);
    }

    public function store(Request $request){
        if(auth()->user()->cliente->hasCarrito()){
            $pedido = auth()->user()->cliente->hasCarrito();
        }else{
            $pedido = Pedido::create([
                'cliente_id' => auth()->user()->cliente->id,
                'pedido_estado_id' => 1,
                'total' => 0,
                'pago_metodo_id' => 4,
                'pago_estado_id' => 1,
            ]);
        }

        $pizza = Pizza::find($request->pizza_id);

        $detalle = DetallePedido::where('pedido_id', $pedido->id)->where('pizza_id', $pizza->id)->first();
        if($detalle){
            $detalle->cantidad = $detalle->cantidad + $request->cantidad;
            $detalle->subtotal = $detalle->cantidad * $pizza->precio;
            $detalle->save();
        }else{
            $detalle = DetallePedido::create([
                'pedido_id' => $pedido->id,
                'pizza_id' => $pizza->id,
                'cantidad' => $request->cantidad,
                'subtotal' => $request->cantidad * $pizza->precio
            ]);
        }

        $pedido->total = $pedido->total + $detalle->subtotal;
        $pedido->save();
        return redirect()->route('carrito.index');

    }

    public function destroy(DetallePedido $detalle){
        $pedido = Pedido::find($detalle->pedido_id);
        $pedido->total = $pedido->total - $detalle->subtotal;
        $pedido->save();
        $detalle->delete();
        if($pedido->total == 0){
            $pedido->delete();
        }
        return redirect()->route('carrito.index');
    }


    public function checkout(Request $request)
    {
        try {
            \Log::info('Inicio del método checkout', ['request' => $request->all()]);
    
            // Buscar el pedido
            $pedido = Pedido::find($request->id);
    
            if (!$pedido || !$pedido->cliente) {
                \Log::error('Pedido o cliente no encontrado', ['id' => $request->id]);
                return response()->json(['error' => 'Pedido o cliente no encontrado'], 404);
            }
            \Log::info('Pedido encontrado', ['pedido' => $pedido]);
    
            // Configuración general
            $tcCommerceID = "d029fa3a95e174a19934857f535eb9427d967218a36ea014b70ad704bc6c8d1c";
            $urlCallback = "https://668e1844-a7e0-4afe-be19-629f3fe5ec1a-00-15zlyu5vdx8z9.kirk.replit.dev/api/urlcallback";
            $urlReturn = "https://40f5-190-180-95-173.ngrok-free.app/carrito/pagado";
            $url = "https://serviciostigomoney.pagofacil.com.bo/api/servicio/pagoqr";
    
            \Log::info('Configuración general establecida', [
                'tcCommerceID' => $tcCommerceID,
                'urlCallback' => $urlCallback,
                'urlReturn' => $urlReturn
            ]);
    
            // Obtener token
            $tokenResponse = $this->obtenerToken();
            \Log::info('Token obtenido', ['tokenResponse' => $tokenResponse]);
    
            if (!isset($tokenResponse["values"])) {
                \Log::error('No se pudo obtener un token válido');
                return response()->json(['error' => 'No se pudo obtener un token válido'], 500);
            }
            $accessToken = $tokenResponse["values"];
            \Log::info('AccessToken configurado', ['accessToken' => $accessToken]);
    
            // Detalles del pedido
            $pedidoDetalle = [
                "Serial" => $pedido->id,
                "Producto" => "Pedido " . $pedido->id,
                "Cantidad" => 1,
                "Precio" => $pedido->total,
                "Descuento" => 0,
                "Total" => $pedido->total,
            ];
            \Log::info('Detalle del pedido generado', ['pedidoDetalle' => $pedidoDetalle]);
    
            // Cuerpo de la solicitud
            $body = [
                "tcCommerceID" => $tcCommerceID,
                "tcNroPago" => "pago-" . rand(100000, 999999),
                "tcNombreUsuario" => $pedido->cliente->user->name,
                "tnCiNit" => (int)$pedido->cliente->ci_nit,
                "tnTelefono" => (int)$pedido->cliente->numeroTelf,
                "tcCorreo" => $pedido->cliente->user->email,
                "tnMontoClienteEmpresa" => 0.01,
                "tnMoneda" => 2,
                "tcUrlCallBack" => $urlCallback,
                "tcUrlReturn" => $urlReturn,
                "taPedidoDetalle" => $pedidoDetalle,
            ];
            \Log::info('Cuerpo de la solicitud generado', ['body' => $body]);
    
            // Encabezados
            $headers = [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $accessToken
            ];
            \Log::info('Encabezados generados', ['headers' => $headers]);
    
            // Cliente HTTP
            $client = new Client();
    
            // Realizar la solicitud
            \Log::info('Enviando solicitud a PagoFácil', ['url' => $url]);
            $response = $client->post($url, [
                'headers' => $headers,
                'json' => $body
            ]);
            $responseContent = $response->getBody()->getContents();
            \Log::info('Contenido crudo de la respuesta', ['response' => $responseContent]);
    
            // Decodificar JSON principal
            $result = json_decode($responseContent, true);
    
            if (json_last_error() !== JSON_ERROR_NONE) {
                \Log::error('Error al decodificar JSON principal', [
                    'error_message' => json_last_error_msg(),
                    'response_content' => $responseContent
                ]);
                return response()->json(['error' => 'Error al procesar la respuesta del servicio'], 500);
            }
    
            // Verificar que `values` exista en la respuesta
            if (!isset($result['values'])) {
                \Log::error('El campo values no está presente en la respuesta', ['result' => $result]);
                return response()->json(['error' => 'Respuesta inesperada del servicio'], 500);
            }
    
            // Dividir el campo `values`
            $valuesParts = explode(";", $result['values']);
    
            if (count($valuesParts) < 2) {
                \Log::error('El campo values no contiene datos esperados', ['values' => $result['values']]);
                return response()->json(['error' => 'Respuesta inesperada en el campo values'], 500);
            }
    
            // Extraer número de transacción
            $nroTransaccion = $valuesParts[0];
    
            // Extraer y decodificar el QR
            $jsonEscaped = $valuesParts[1];
            $qrData = json_decode($jsonEscaped, true);
    
            if (json_last_error() !== JSON_ERROR_NONE) {
                \Log::error('Error al decodificar JSON del campo values', [
                    'error_message' => json_last_error_msg(),
                    'json_escaped' => $jsonEscaped
                ]);
                return response()->json(['error' => 'Error al procesar los datos del QR'], 500);
            }
    
            // Extraer el texto del QR
            $qrImage = $qrData['qrImage'] ?? null;
            $qrImagse = "data:image/png;base64," . $qrImage;
    
            if (!$qrImage) {
                \Log::error('Texto del QR no encontrado en los datos del QR', ['qrData' => $qrData]);
                return response()->json(['error' => 'No se encontró el texto del QR'], 500);
            }
    
            \Log::info('QR y número de transacción generados correctamente', [
                'qrImage' => $qrImagse,
                'nroTransaccion' => $nroTransaccion
            ]);
    
            return response()->json([
                'success' => true,
                'qrText' => $qrImagse,
                'nroTransaccion' => $nroTransaccion
            ]);
        } catch (\Throwable $th) {
            \Log::error('Error en checkout', [
                'error' => $th->getMessage(),
                'line' => $th->getLine(),
                'file' => $th->getFile()
            ]);
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
    
    public function obtenerToken()
    {
        try {
            // Configuración para obtener el token
            $url = "https://serviciostigomoney.pagofacil.com.bo/api/servicio/login";
            $body = [
                'TokenService' => '51247fae280c20410824977b0781453df59fad5b23bf2a0d14e884482f91e09078dbe5966e0b970ba696ec4caf9aa5661802935f86717c481f1670e63f35d5041c31d7cc6124be82afedc4fe926b806755efe678917468e31593a5f427c79cdf016b686fca0cb58eb145cf524f62088b57c6987b3bb3f30c2082b640d7c52907',
                'TokenSecret' => '9E7BC239DDC04F83B49FFDA5'
            ];

            // Encabezados
            $headers = [
                'Accept' => 'application/json'
            ];

            // Cliente HTTP
            $client = new Client();

            // Realizar solicitud
            $response = $client->post($url, [
                'headers' => $headers,
                'json' => $body
            ]);

            // Procesar respuesta
            $result = json_decode($response->getBody()->getContents(), true);

            return $result;
        } catch (\Throwable $th) {
            throw new \Exception("Error al obtener el token: " . $th->getMessage());
        }
    }

    public function urlCallback(Request $request)
    {
        try {
            \Log::info('Callback recibido', ['data' => $request->all()]);
            $arreglo = ['error' => 0, 'status' => 1, 'message' => "Pago realizado correctamente.", 'values' => true];
        } catch (\Throwable $th) {
            $arreglo = ['error' => 1, 'status' => 1, 'messageSistema' => "[TRY/CATCH] " . $th->getMessage(), 'message' => "No se pudo realizar el pago, por favor intente de nuevo.", 'values' => false];
        }
        \Log::info('Callback recibido', ['data' => $arreglo]);
        return response()->json($arreglo);
    }

    public function pagado(){
        return Inertia::render('Carrito/Pagado');
    }
    public function actualizarEstadoPedido(Request $request)
{
    try {
        \Log::info('Actualizando estado del pedido', ['request' => $request->all()]);

        // Validar datos
        $request->validate([
            'pedido_id' => 'required|exists:pedidos,id',
            'pedido_estado_id' => 'required|integer',
            'pago_estado_id' => 'required|integer',
        ]);

        // Buscar el pedido
        $pedido = Pedido::find($request->pedido_id);

        if (!$pedido) {
            \Log::error('Pedido no encontrado', ['pedido_id' => $request->pedido_id]);
            return response()->json(['error' => 'Pedido no encontrado'], 404);
        }

        // Actualizar el pedido
        $pedido->pedido_estado_id = $request->pedido_estado_id;
        $pedido->pago_estado_id = $request->pago_estado_id;
        $pedido->save();

        \Log::info('Pedido actualizado correctamente', ['pedido' => $pedido]);

        return response()->json(['success' => true, 'message' => 'Pedido actualizado correctamente']);
    } catch (\Throwable $th) {
        \Log::error('Error al actualizar el pedido', [
            'error' => $th->getMessage(),
            'line' => $th->getLine(),
            'file' => $th->getFile()
        ]);
        return response()->json(['error' => $th->getMessage()], 500);
    }
}

}
