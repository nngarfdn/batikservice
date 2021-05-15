<?php

namespace App\Http\Controllers;
use App\Batik;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;

class BatikController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->user = JWTAuth::parseToken()->authenticate();
    }

    public function index()
    {
        return $this->user
            ->batiks()
            ->get(['nama', 'asal', 'makna', 'foto'])
            ->toArray();
    }

    public function show($id)
    {
        $batik = $this->user->batiks()->find($id);

        if (!$batik) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, batik with id ' . $id . ' cannot be found'
            ], 400);
        }

        return $batik;
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required',
            'asal' => 'required',
            'makna' => 'required',
            'foto' => 'required'
        ]);

        $product = new Batik();
        $product->nama = $request->nama;
        $product->asal = $request->asal;
        $product->makna = $request->makna;
        $product->foto = $request->foto;

        if ($this->user->batiks()->save($product))
            return response()->json([
                'success' => true,
                'product' => $product
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'Sorry, product could not be added'
            ], 500);
    }

    public function update(Request $request, $id)
    {

        $product = new Batik();
        $product->nama = $request->nama;
        $product->asal = $request->asal;
        $product->makna = $request->makna;
        $product->foto = $request->foto;

        
        $batik = $this->user->batiks()->find($id);


        if (!$batik) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, product with id ' . $id . ' cannot be found'
            ], 400);
        }

        $updated = $batik->fill($request->all())
            ->save();

        if ($updated) {
            return response()->json([
                'success' => true
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, product could not be updated'
            ], 500);
        }
    }

    public function destroy($id)
    {
        $batik = $this->user->batiks()->find($id);

        if (!$batik) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, product with id ' . $id . ' cannot be found'
            ], 400);
        }

        if ($batik->delete()) {
            return response()->json([
                'success' => true
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Product could not be deleted'
            ], 500);
        }
    }
}
