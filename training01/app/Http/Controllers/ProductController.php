<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use Ramsey\Uuid\Uuid;

class ProductController extends Controller
{
    protected $path = 'Images';
    public function index(request $request)
    {
        $data = $request->all();
        // dd($data);
        $response = ['success' => false, 'data' => [], 'message' => ''];

        $products = Product::select('product_id', 'product_name', 'product_price', 'product_image', 'description', 'is_sales');
        // dd($products);  
        if ($request->filled('name')) {
            $products->where('product_name', 'like', '%' . $data['name'] . '%');
        }
        if ($request->filled('price_from')) {
            $products->where('product_price', '>=', $data['price_from']);
        }
        if ($request->filled('price_to')) {
            $products->where('product_price', '<=', $data['price_to']);
        }
        if ($request->filled('is_sales')) {
            $products->where('is_sales', $data['is_sales']);
        }
        $products = $products->orderBy('product_id', 'desc')->paginate(20);
        $i = $products->currentPage()*$products->perPage() -$products->currentPage();
        if (request()->ajax()) {
                $table = view('products.table', ['products' => $products])->render();
                $paginate = $products->links()->toHTML();
                return response()->json(['html' => $table, 'pagination' => $paginate]);
        }

        return view('products.index', ['products' => $products,'stt'=>$i]);
    }
    public function save(Request $request)
    {
        $data = $request->all();
        if ( !isset($request->id)) {
            $result = $this->create($request);
            return response()->json($result);
        } else {
            $result = $this->edit($request);
            return response()->json($result);
        }
    }

    public function create($request)
    {   
        $response = ['success' => false, "Errors" => ''];

        $messageErrors = [
            'product_name.required' => 'Tên sản phẩm không được để trống',
            'product_name.min' => 'Tên sản phẩm phải lớn hơn 5 ký tự',
            'product_price.required' => 'Giá bán không được để trống',
            'product_price.numeric' => 'Giá bán chỉ được nhập số',
            'product_price.min' => 'Giá bán không được nhỏ hơn 0',
            'is_sales.required' => 'Trạng thái không được để trống',
            'product_image.max' => 'Hình ảnh sản phẩm không vượt quá 2MB',
            'product_image.mimes' => 'Hình ảnh sản phẩm phải là file *.jpeg, *.png, *.jpg'
        ];
        $rules = [
            'product_name' => 'required|min:5',
            'product_price' => 'required|min:0|numeric',
            'is_sales' => 'required',
        ];
        if ($request->product_image!==null) {            
            $rules['product_image'] = 'mimes:jpeg,png,jpg|max:2048|dimensions:max_width=1024,max_height=1024';
        }
        $validator = Validator::make($request->all(), $rules, $messageErrors);
        if ($validator->fails()) {
            $response['Errors'] = $validator->errors();
            // dd($response);
            return $response;
        } else {
            $newProduct = [
                'product_name' => $request['product_name'],
                'product_price' => $request['product_price'],
                'is_sales' => $request['is_sales'],
                'description' => $request['description'],
                'created_at' => now()
            ];
            $result = Product::create($newProduct);
            if ($result) {
                $response['success'] = true;
                if ($request->hasFile('product_image')) {
                    $imageName = $this->path . '/' . $result->product_name . '.' . $result->product_id . '.' . Uuid::uuid4() . '.' . $request->product_image->extension();
                    $result->product_image = $imageName;
                    if ($result->save()) {
                        $request->product_image->move(public_path('Images'), $imageName);
                        $response['type'] = 'success';
                        $response['message'] = "Đã lưu thành công";
                        $response['success'] = true;
                        return $response;
                    }
                }
            }
            $response['type'] = 'warning';
            // dd($response);
            $response['message'] = "Đã lưu thành công nhưng chưa lưu hình ảnh sản phẩm";
            return $response;
        }
    }
    public function edit($request)
    {
        
        $response = ['success' => false, "Errors" => []];
        $messageErrors = [
            'product_name.required' => 'Tên sản phẩm không được để trống',
            'product_name.min' => 'Tên sản phẩm phải lớn hơn 5 ký tự',
            'product_price.required' => 'Giá bán không được để trống',
            'product_price.numeric' => 'Giá bán chỉ được nhập số',
            'product_price.min' => 'Giá bán không được nhỏ hơn 0',
            'is_sales.required' => 'Trạng thái không được để trống',
            'product_image.max' => 'Hình ảnh sản phẩm không vượt quá 2MB',
            'product_image.mimes' => 'Hình ảnh sản phẩm phải là file *.jpeg, *.png, *.jpg',
            'product_image.dimensions' =>'Hình ảnh chiều rộng không được quá 1024px',
                
        ];
        $rules = [
            'product_name' => 'required|min:5',
            'product_price' => 'required|min:0|numeric',
            'is_sales' => 'required',
        ];
        if ($request->product_image!==null) {            
            $rules['product_image'] = 'mimes:jpeg,png,jpg|max:2048|dimensions:max_width=1024';
        }
        $validator = Validator::make($request->all(), $rules, $messageErrors);
        if ($validator->fails()) {
            $response['Errors'] = $validator->errors();
            return $response;
        }
        $product = Product::find($request->id);

        if ($product) {
            $product->product_name = $request->input('product_name');
            $product->product_price = $request->input('product_price');
            $product->is_sales = $request->input('is_sales');
            $product->description = $request->input('description');
            $product->updated_at = now();
            $product->save();
            if ($request->hasFile('product_image')) {
                $imageOld = public_path($product->product_image);
                //check and delete old image
                if (!empty ($product->product_image)) {
                    if (file_exists($imageOld)) {
                        unlink($imageOld);
                    }
                }
                // save new image
                $imageNew = $this->path . '/' . $product->product_name . '.' . $product->product_id . '.' . Uuid::uuid4() . '.' . $request->product_image->extension();
                $product->product_image = $imageNew;
                if ($product->save()) {
                    $request->product_image->move(public_path('Images'), $imageNew);
                }
            }
            $response['type'] = 'success';
            $response['message'] = 'Đã chỉnh sửa sản phẩm '.$product->product_name. ' thành công!';
            $response['success'] = true;
            return $response;
        }
        $response['type'] = 'danger';
        $response['message'] = "Không tìm thấy sản phẩm, vui lòng thử lại";
        $response['success'] = false;

        return $response;
    }
    public function delete(Request $request)
    {
        $response = ['success' => false];
        if (!empty ($request->input('id'))) {
            $product = Product::find($request->input('id'));
            $result = $product->delete();
            if ($result) {
                $response = ['success' => true];
            }
        }
        return response()->json($response);
    }
    public function getImageProductById(Request $request)
    {
        $response = ['success' => false];
        if ($request['id'] != null) {
            $product = Product::find($request['id']);
            if ($product->product_image!=null) {
                $url = asset($product->product_image);
                $img = ' <img style="width: 300px ;height: 200px"  src="' . $url . '" class="rounded mx-auto d-block" alt="">';
                // dd($img);
                $response['success'] = true;
                $response['img'] = $img;
                // dd($response);
                return response()->json( $response);
            }
            return response()->json($response);
        }
    }
    public function deleleImageProductById(Request $request)
    {
        if ($request['id'] != null) {
            $respone = ['success' =>false, 'message' => '', 'type' => ''];
            $product= Product::find($request['id']);
            if($product){
                $imageOld = public_path($product->product_image);
                //check and delete old image
                if (!empty ($product->product_image)) {
                    if (file_exists($imageOld)) {
                        unlink($imageOld);
                        $product->product_image="";
                        $product->save();
                        $respone['success']= true;
                        $respone['message'] = 'Xóa hình ảnh thành công!';
                        $respone['type']= 'success';
                        return response()->json($respone);
                    }
                }
                $respone['message'] = 'Sản phẩn không có hình ảnh';
                $respone['type']= 'warning';
                return response()->json($respone);

            }
        }
        $respone['message'] = 'không tìm thấy sản phẩm, vui lòng thử lại!';
        $respone['type']= 'danger';
        return response()->json($respone);
    }
}
