<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\catagory;
use App\Models\Product;
use App\Models\Order;
use PDF;
use Illuminate\Support\Facades\Auth;
use Notification;

class AdminController extends Controller
{
    public function view_catagory()
    {   
        if(Auth::id())
        {
            $data =catagory::all();
            return view('admin.catagory', compact('data'));
        }
        else
        {
            return redirect('login');
        }
       
    }

    public function add_catagory(Request $request)
    {
        $data =new catagory;
        $data->catagory_name =$request->catagory;
        $data->save();
        return redirect()->back()->with('message','Catagory Added Successfully!');
    }

    public function delete_catagory($id)
    {
        $data=catagory::find($id);
        $data->delete();
        return redirect()->back()->with('message', 'Catagory Deleted Successfully');
    }

    public function view_product()
    {
        $catagory=catagory::all();
        return view('admin.product' , compact('catagory'));
    }

    public function add_product(Request $request)
    {
    $product = new Product;
    $product->title = $request->title;
    $product->description = $request->description;
    $product->price = $request->price;
    $product->quantity = $request->quantity;
    $product->discount_price = $request->dis_price;
    $product->catagory = $request->catagory;

    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move('product', $imageName);
        $product->image = $imageName;
    }

    $product->save();

    return redirect()->back()->with('message','Product Added Successfully');
    }

    public function show_product()
    {
        $product=Product::all();
        return view('admin.show_product' ,compact('product'));
    }

    public function delete_product($id)
    {
        $product=product::find($id);
        $product->delete();
        return redirect()->back()->with('message','Product Deleted Successfully');
    }
    
    public function update_product($id)
    {
        $product=product::find($id);
        $catagory=catagory::all();
        return view('admin.update_product',compact('product', 'catagory'));
    }
    public function update_product_confirm(Request $request, $id)
    {
        if(Auth::id())
        {
            $product = Product::find($id);
            $product->title = $request->title;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->discount_price = $request->dis_price;
            $product->catagory = $request->catagory;
            $product->quantity = $request->quantity;
        
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('product'), $imageName);
                $product->image = $imageName;
            }
        
            $product->save();
            return redirect()->back()->with('message' ,'Product Updated Successfully!');
        }
        else
        {
            return redirect('login');
        }
 
    }

    public function order()
    {
        $order=order::all();
        return view('admin.order' ,compact('order'));
    }
   
    public function delivered($id)
    {
        $order=order::find($id);

        $order->delivery_status="delivered";
        $order->payment_status="Paid";

        $order->save();
        return redirect()->back();
    }

    public function print_pdf($id)
    {
        $order=order::find($id);
        $pdf=PDF::loadview('admin.pdf', compact('order'));
        return $pdf->download('order_details.pdf');
    }

    public function searchdata(Request $request)
    {
        $searchText = $request->search;
        $order = order::where(function ($query) use ($searchText) {
            $query->where('name', 'LIKE', '%' . $searchText . '%')
                  ->orWhere('phone', 'LIKE', '%' . $searchText . '%')
                  ->orWhere('product_title', 'LIKE', '%' . $searchText . '%');
        })->get();
    
        return view('admin.order', compact('order'));
    }
}
// dd($request->all());