   <section class="welcome_area wow fadeInRight" data-wow-delay=".25s">
            <div class="welcome_slides owl-carousel">
                @foreach ($media as $item)
                    <div class="single_slide height-800 bg-img background-overlay" style="background-image: url(uploads/images/sliders/{{ $item['image'] }});">
                        <div class="container h-100">
                            <div class="row h-100 align-items-center">
                                <div class="col-12">
                                    <div class="welcome_slide_text">
                                        @if ($item['h6'] !='')
                                           <h6 data-animation="bounceInDown" data-delay="0" data-duration="500ms">{{ $item['h6'] }}</h6>
                                        @endif
                                        @if ($item['h2'] !='')
                                            <h2 data-animation="fadeInUp" data-delay="500ms" data-duration="500ms">Fashion Trends</h2>
                                        @endif
                                        @if ($item['button'])
                                             <a href="#" class="btn karl-btn" data-animation="fadeInUp" data-delay="1s" data-duration="500ms">{{ $item['button'] }}</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>