@extends('admin.layouts.admin')

@section('js')

<script src="{{ url('dist/js/admin/products.js') }}"></script>

@stop


@section('content')
<input type="hidden" value="{{ csrf_token() }}" id="token"></input>
<!-- Main content -->
<section class="content-header">
  <h1>
    Товары
    <!-- <small>Список товаров</small> -->
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Главная</a></li>
    <li class="active">Таблицы</li>
  </ol>

</section>

<section class="content-header">
  <div class="row">
    <div class="col-md-3">
      <a href="/admin/product-add"><button type="button" class="btn btn-block btn-primary btn-flat add-product-button">Добавить</button></a>
    </div>
  </div>
</section>


<section class="content-header">
  <form>
    <div class="row">
      <div class="col-md-2">
        <select class="form-control" name="brendId">
          <option value="">Выберите бренд</option>
          @foreach($brends as $brend)
          <option value="{{$brend->id}}" @if(isset($filter['brendId']) && $filter['brendId'] == $brend->id) selected @endif>{{$brend->name}}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-2">
        <select class="form-control" name="categoryId">
          <option value="">Выберите категорию</option>
          @foreach($categories as $categoryItem)
          <option value="{{$categoryItem->id}}" @if(isset($filter['categoryId']) && $filter['categoryId'] == $categoryItem->id) selected @endif>{{$categoryItem->name}}</option>
          @endforeach
        </select>
      </div>

      <div class="col-md-3">
        <select class="form-control" name="group">
          <option value="">Выберите группу</option>
          @foreach($groups as $group)
          <option value="{{$group->group}}" @if(isset($filter['group']) && $filter['group'] == $group->group) selected @endif>{{$group->group}}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-3">
        <input type="text" class="form-control product-search-button" @if(isset($filter['search'])) value="{{$filter['search']}}" @endif name="search" placeholder="Поиск ...">
      </div>
      <div class="col-md-2 col-xs-12">
        <button type="submit" class="btn btn-block btn-primary btn-flat add-product-button" >Найти</button>
      </div>
    </div>
  </form>
</section>

<section class="content">
  @if(Session::get('name')) 
  <div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h4><i class="icon fa fa-check"></i> Товар добавлен!</h4>
    Товар {{ Session::get('name') }} успешно добавлен
  </div>
  @endif
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Hover Data Table</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table id="example2" class="table table-bordered table-hover">
            <thead>
              <tr>
                <th>Имя</th>
                <th>Опт</th>
                <th>Розн</th>
                <th>Описание</th>
                <th>Категория</th>
                <th>Изображения</th>
                <th>Поиск</th>
                <th>Берут</th>
                <th>Удалить</th>
              </tr>
            </thead>
            <tbody id="productList">
              @foreach($products as $product)
              <tr>
                <td><a href="/admin/product-update/{{$product->id}}">{{$product->name}}</a></td>
                <td>
                  @if($product->active)
                  <img src="{{ url('/site/images/active.jpg') }}">
                  @else
                  <img src="{{ url('/site/images/no-active.jpg') }}">
                  @endif
                </td>

                <td>
                 @if($product->active_wholesale)
                 <img src="{{ url('/site/images/active.jpg') }}">
                 @else
                 <img src="{{ url('/site/images/no-active.jpg') }}">
                 @endif
               </td>

               <td>
                @if($product->description)
                <img src="{{ url('/site/images/active.jpg') }}">
                @else
                <img src="{{ url('/site/images/no-active.jpg') }}">
                @endif
              </td>
              <td></td>

              <td>
                @if($product->hasImage)
                <img src="{{ url('/site/images/active.jpg') }}">
                @else
                <img src="{{ url('/site/images/no-active.jpg') }}">
                @endif
              </td>

              <td><a href="/admin/product-search/{{$product->id}}">Поиск</a></td>
              <td><a href="/admin/with-product/{{$product->id}}">Берут</a></td>
              <td>
                <form action="/admin/product-delete" method="POST" onsubmit="return confirm('Вы точно хотите удалить товар: {{$product->name}} ?')">
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  <input type="hidden" name="product_id" value="{{$product->id}}">
                  <button type="submit" class="btn btn-block btn-danger btn-flat">Удалить</button>
                </form>
              </td>
            </tr>
            @endforeach
          </table>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->




    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->

  <div class="row" id="paginator">
    <div class="col-xs-12">
        <?php echo $products->render(); ?>
    </div>
  </div>
</section>
<!-- /.content -->

@stop