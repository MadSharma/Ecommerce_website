<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->


    @include('admin.css');

    <style type="text/css">
    .div_center
    {
      text-align: center;
      padding-top: 40px
    }
    .font_size
    {
      font-size: 40px;
      padding-bottom: 40px; 
    }
    .text_color
    {
      color: black;
      padding: 20px;
    }
    label
    {
      display: inline-block;
      width: 200px;
    }
    .div_design
    {
      padding-bottom: 15px;
    }

    </style>
  </head>
  <body>
    <div class="container-scroller">
    
      <!-- partial:partials/_sidebar.html -->
      @include('admin.sidebar');
      <!-- partial -->
      
        <!-- partial:partials/_navbar.html -->
        @include("admin.header");

        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">

            @if(session()->has('message'))

            <div class="alert alert-success">
              {{session()->get('message')}}
            </div>
            @endif

            <div class="div_center">
              <h1 class="font_size">Update Product</h1>

            <form action="{{url('/update_product_confirm',$product->id)}}" method="POST" enctype="multipart/form-data">
             
              @csrf

            <div class="div_design">
                <label>Product Title :</label>
                <input class="text_color" type="text" name="title" placeholder="write a title" required="" value="{{$product->title}}">
            </div>
            <div class="div_design">
                <label>Product Description :</label>
                <input class="text_color" type="text" name="description" placeholder="write a description" required="" value="{{$product->description}}" >
            </div>
            <div class="div_design">
                <label>Product Price :</label>
                <input class="text_color" type="number" name="price" placeholder="write the price" required="" value="{{$product->price}}" >
            </div>
            <div class="div_design">
                <label>Discount Price :</label>
                <input class="text_color" type="number" name="dis_price" placeholder="Discount is applied"  value="{{$product->discount_price}}" >
            </div>
            <div class="div_design">
                <label>Product Quantity :</label>
                <input class="text_color" type="number" name="quantity" placeholder="write the quantity" required=""  value="{{$product->quantity}}" >
            </div>

            <div class="div_design">
                <label>Product Catagory :</label>
                <select class="text_color" name="catagory" required="">
                  <option value="{{$product->catagory}}" selected="">{{$product->catagory}}</option>
                  
                  @foreach($catagory as $catagory)
                    <option value="{{$catagory->catagory_name}}">{{$catagory->catagory_name}}</option>
                  @endforeach

                </select>
            </div>

            <div class="div_design">
                <label>Change Product Image Here :</label>
                <img style="margin: auto;" height="100" width="100" src="/product/{{$product->image}}" alt="">
            </div>
            <div class="div_design">
                <label>Change Product Image Here :</label>
                <input type="file" name="image" >
            </div>

            <div class="div_design">
                <input type="submit" value="Update Product" class="btn btn-primary">
            </div>
          </form>
            </div>
          </div>
        </div>
    <!-- container-scroller -->

    <!-- plugins:js -->
       @include('admin.script');
    <!-- End custom js for this page -->
  </body>
</html>