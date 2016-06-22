        <ul class="sidebar-menu">
          <li class="header">МЕНЮ</li>
          <!-- Optionally, you can add icons to the links -->
          <li @if(Request::url() == 'http://kaleydoskop.ap.org.ua/admin') class="active" @endif><a href="/admin"><i class="fa fa-dashboard"></i> <span>Главная</span></a></li>
          <li @if(Request::url() == 'http://kaleydoskop.ap.org.ua/admin/products') class="active" @endif><a href="/admin/products"><i class="fa fa-shopping-cart"></i> <span>Товары</span></a></li>
          <li @if(Request::url() == 'http://kaleydoskop.ap.org.ua/admin/orders') class="active" @endif><a href="/admin/orders"><i class="fa  fa-gift"></i> <span>Заказы</span></a></li>
          <li @if(Request::url() == 'http://kaleydoskop.ap.org.ua/admin/brends') class="active" @endif><a href="/admin/brends"><i class="fa fa-cc-jcb"></i> <span>Бренды</span></a></li>
          <li @if(Request::url() == 'http://kaleydoskop.ap.org.ua/admin/feedback') class="active" @endif><a href="/admin/feedback"><i class="fa fa-send"></i> <span>Обратная связь</span></a></li>
          <li @if(Request::url() == 'http://kaleydoskop.ap.org.ua/admin/components') class="active" @endif><a href="/admin/components"><i class="fa fa-slack"></i> <span>Компоненты</span></a></li>

          <li class="treeview">
            <a href="#">
              <i class="fa fa-folder"></i> <span>Категории</span>
              <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
              <li><a href="/admin/categories"><i class="fa fa-circle-o"></i>Категории</a></li>
              <li><a href="/admin/subcategories"><i class="fa fa-circle-o"></i>Подкатегории</a></li>
              <li><a href="/admin/attributes"><i class="fa fa-circle-o"></i>Атрибуты</a></li>
            </ul>
          </li>

          <li @if(Request::url() == 'http://kaleydoskop.ap.org.ua/admin/users') class="active" @endif><a href="/admin/users"><i class="fa fa-child"></i> <span>Пользователи</span></a></li>


          @if(Auth::user()->role == 'ander')
          <li @if(Request::url() == 'http://kaleydoskop.ap.org.ua/admin/users/wholesalers') class="active" @endif><a href="/admin/users/wholesalers"><i class="fa  fa-balance-scale"></i> <span>Оптовики</span></a></li>
          @endif

          <li @if(Request::url() == 'http://kaleydoskop.ap.org.ua/admin/articles') class="active" @endif><a href="/admin/articles"><i class="fa fa-commenting-o"></i> <span>Статьи</span></a></li>

          <li class="treeview">
            <a href="#">
              <i class="fa fa-folder"></i> <span>Рассылки</span>
              <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
              <li><a href="/admin/intake"><i class="fa fa-circle-o"></i>Сообщить о поступлении</a></li>
              <li><a href="/admin/distribution"><i class="fa fa-circle-o"></i>Рассылка</a></li>
            </ul>
          </li>
        </ul>