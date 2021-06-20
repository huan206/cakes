<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmail;
use App\Models\Bill;
use App\Models\BillDetail;
use App\Models\Cart;
use App\Models\Customer;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\Slide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

// use PhpParser\Node\Expr\Print_;

// use Illuminate\Support\Facades\DB;

class PageController extends Controller
{
    public function getIndex()
    {
        $slide = Slide::all();
        $new_product = Product::where('new', 1)->paginate(4);
        $promotion_product = Product::where('promotion_price', '<>', 0)->paginate(8);
        return view('page.trangchu', compact('slide', 'new_product', 'promotion_product'));
    }

    public function getLoaiSp($type)
    {
        $sp_theoloai = Product::where('id_type', $type)->get();
        $type_product = ProductType::all();
        $sp_khac = Product::where('id_type', '<>', $type)->paginate(3);

        return view('page.loai_sanpham', compact('sp_theoloai', 'type_product', 'sp_khac'));
    }

    public function getDetail(Request $request)
    {
        $sanpham = Product::where('id', $request->id)->first();
        // $sp_khac = Product::where('id_type', '=', $request->type)->paginate(3);
        return view('page.chitiet_sanpham', compact('sanpham'));
    }
    public function getContact()
    {
        return view('page.lienhe');
    }
    public function getAbout()
    {
        return view('page.about');
    }
    //CRUD
    public function getIndexAdmin()
    {
        $new_product = Product::all();
        return view('Admin.admin')->with(['products' => $new_product]);
    }
    public function getAdminAdd()
    {
        return view('Admin.formAdd');
    }
    public function postAdminAdd(Request $request)
    {
        $product = new Product();
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = $file->getClientOriginalName('image');
            $file->move('source/image/product', $fileName);

            $file_name = null;
            if ($request->file('image') != null) {
                $file_name = $request->file('image')->getClientOriginalName();
            }
            $product->name = $request->name;
            $product->image = $file_name;
            $product->description = $request->description;
            $product->unit_price = $request->unit_price;
            $product->promotion_price = $request->promotion_price;
            $product->unit = $request->unit;
            $product->new = $request->new;
            $product->id_type = $request->type;
            $product->save();
            return $this->getIndexAdmin();
        }
    }
    public function getAdminEdit($id)
    {
        $product = Product::find($id);
        return view('Admin.formEdit')->with(['product' => $product]);
    }
    public function postAdminEdit(Request $request)
    {
        $id = $request->id;
        $product = Product::find($id);
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = $file->getClientOriginalName('image');
            $file->move('source/image/product', $fileName);
        }

        if ($request->file('image') != null) {
            $product->image = $fileName;
        }
        $product->name = $request->name;
        $product->id_type = $request->type;
        $product->description = $request->description;
        $product->unit_price = $request->unit_price;
        $product->promotion_price = $request->promotion_price;
        $product->unit = $request->unit;
        $product->new = $request->new;
        $product->save();
        return $this->getIndexAdmin();
    }
    public function postAdminDelete($id)
    {
        $product = Product::find($id);
        $product->delete();
        return $this->getIndexAdmin();
    }
    public function getAddToCart(Request $req, $id)
    {
        $product = Product::find($id);
        $oldCart = Session('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->add($product, $id);
        $req->session()->put('cart', $cart);
        return redirect()->back();
    }
    public function getDelItemCart($id)
    {
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->removeItem($id);
        if (count($cart->items) > 0) {
            Session::put('cart', $cart);

        } else {
            Session::forget('cart');
        }
        return redirect()->back();
    }
    public function getCheckout(Request $req)
    {
        return view('page.order');
    }
    public function postCheckout(Request $req)
    {
        $cart = Session::has('cart')?Session::get('cart'):null;
        // dd($cart);
        $customer = new Customer;
        $customer->name = $req->name;
        $customer->gender = $req->gender;
        $customer->email = $req->email;
        $customer->address = $req->address;
        $customer->phone_number = $req->phone;
        $customer->note = $req->notes;
        $customer->save();

        $bill = new Bill;
        $bill->id_customer = $customer->id;
        $bill->date_order = date('Y-m-d');
        $bill->total = $cart->totalPrice;
        $bill->payment = $req->payment_method;
        $bill->note = $req->notes;
        $bill->save();

        foreach ($cart->items as $key => $value) {
            $bill_detail = new BillDetail;
            $bill_detail->id_bill = $bill->id;
            $bill_detail->id_product = $key; //$value['item']['id'];
            $bill_detail->quantity = $value['qty'];
            $bill_detail->unit_price = $value['price'] / $value['qty'];
            $bill_detail->save();
        }
        Session::forget('cart');
        $message = [
            'type' => 'Email thông báo đặt hàng thành công',
            'thanks' => 'Cảm ơn ' . $req->name . ' đã đặt hàng.',
            'cart'=>$cart,
            'content' => 'Đơn hàng đã được xác nhận.',
        ];
        SendEmail::dispatch($message, $req->email)->delay(now()->addMinute(1));
        echo "<script>alert('Đặt hàng thành công')</script>";

        Session::forget('cart');
        return redirect()->back()->with('thongbao', 'Đặt hàng thành công');
    }
}
