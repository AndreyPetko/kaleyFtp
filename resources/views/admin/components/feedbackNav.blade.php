      <div class="box box-solid">
        <div class="box-header with-border">
          <h3 class="box-title">Folders</h3>

          <div class="box-tools">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
          </div>
        </div>

        <div class="box-body no-padding">
          <ul class="nav nav-pills nav-stacked">
            <li  @if(Request::path() == "admin/feedback") class="active" @endif><a href="/admin/feedback"><i class="fa fa-inbox"></i> Обратная связь
              </a></li>

              @if(Auth::user()->role == 'admin')
              <li @if(Request::path() == "admin/reviews") class="active" @endif><a href="/admin/reviews"><i class="fa fa-envelope-o"></i> Комментарии</a></li>
              <li @if(Request::path() == "admin/callbacks") class="active" @endif><a href="/admin/callbacks"><i class="fa fa-phone"></i> Обратные звонки</a></li>
              @endif
            </ul>
          </div>
        </div>
