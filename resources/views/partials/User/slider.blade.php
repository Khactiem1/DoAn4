<!-- BEGIN SLIDER -->
<span class="none">{{$activeImage = 'active'}}</span>
<span class="none">{{$active = 'active'}}</span>
<div class="page-slider margin-bottom-35">
    <div id="carousel-example-generic" class="carousel slide carousel-slider">
        <!-- Wrapper for slides -->
        <div class="carousel-inner" role="listbox">
            @for($i = 0; $i < count($sliders);$i++)
                <div class="item {{$activeImage}}">
                    <img src="{{asset('')}}{{$sliders[$i]->image_path}}">
                </div>
                <span class="none">{{$activeImage = ''}}</span>
            @endfor
        </div>

        <!-- Controls -->
        <a class="left carousel-control carousel-control-shop" href="#carousel-example-generic" role="button" data-slide="prev">
            <i class="fa fa-angle-left" aria-hidden="true"></i>
        </a>
        <a class="right carousel-control carousel-control-shop" href="#carousel-example-generic" role="button" data-slide="next">
            <i class="fa fa-angle-right" aria-hidden="true"></i>
        </a>
    </div>
</div>
<!-- END SLIDER -->
