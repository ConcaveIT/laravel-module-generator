@if(!empty($menu->submenues))

    <ol class="dd-list list-group">
        @foreach($menu->submenues as $kk => $sub_category)
            <li class="dd-item list-group-item"  data-id="{{ $sub_category['id'] }}" >
                <div class="dd-handle" > <i class="icofont-navigation-menu"></i> </div>

                <div class="dd-option-handle">
                   {{ $sub_category['title'] }}

                   <a href="javascript:void(0)" class="text-success edit_category_btn pull-right" data-category-id="{{$sub_category['id']}}"><i class="icofont-pencil-alt-5"></i></a>

                </div>
                @if(!empty($sub_category->submenues))
                   @include('core.sidemenu.child-menu-view', [ 'menu' => $sub_category])
                @endif
            </li>
         @endforeach
    </ol>
@endif
