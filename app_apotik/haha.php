@extends('home')

@section('title-navbar')
Data Konten
@endsection

@section('title')
Timeline Konten
@endsection


@section('content')


<style>
.backTop {
  position: fixed;
  bottom: 0;
  right: 0;
  display: inline-block;
  padding: 1em;
  margin: 1em;
  background: #E8E8E8;
  opacity: 0.3;
  /*border: 2px solid #000;*/
  border-radius: 25px;
}
.backTop:hover {
  cursor: pointer;
}
</style>






<div class="layout-px-spacing">
   <div class="row layout-top-spacing">

      <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">




<div class="alert alert-danger mb-4" role="alert">
    <button type="button" class="close" data-dismiss="alert"
aria-label="Close"><svg> ... </svg></button>
    <strong>Yuk, cek berita terbaru kami !</strong> <br><a
href="https://cmihospital.com/id/artikel-detail/read/sepelekan-pola-hidup-ginjal-pun-terancam"
target="_blank">Artikel : Sepelekan pola hidup, ginjal pun terancam
.</a></button>
</div>





         <div class="widget-content widget-content-area br-6">
            <a href="{{ url('/konten') }}" class="btn btn-light">< Kembali</a>
            <div class="timeline-simple">


               <div class="timeline-list">
                  <!--<p class="meta-update-day">Hari ini</p>-->
                <div>
                <br><br>
                  @foreach($timeline as $p)
                      <div class="timeline-post-content">
                         <a href="{{ url('profile/'.$p->no_pegawai) }}">
                         <div class="user-profile">
                            @if($p->foto_pegawai_depan != null)
                            <img src="{{
asset('assets/foto_pegawai/'.$p->foto_pegawai_depan) }}" alt="Foto
Pegawai">
                            @else($p->foto_pegawai_depan == null)
                            <img src="{{ asset('assets/img/user.png')
}}" alt="">
                            @endif
                         </div>
                         </a>
                         <div class="">
                            <a href="{{ url('profile/'.$p->no_pegawai)
}}"><h4>{{ $p->gelar_depan }} {{ $p->nama_pegawai }} {{
$p->gelar_belakang }}</h4></a>
                            <p class="meta-time-date"><font
size="-2">{{ \Carbon\Carbon::parse($p->created_at)->diffForHumans()
}}</font></p>
                            <div class="">
                                  <p class="post-text">{!!
$p->konten_isi !!}</p>
                            </div>
                         </div>
                      </div>
                  @endforeach


                </div>
                </div>
                <br>
                <div class="pagination-custom_solid">
                    {{ $timeline->links() }}
                </div>

                <div class="backTop">


<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
stroke-linecap="round" stroke-linejoin="round" class="feather
feather-arrow-up-circle"><circle cx="12" cy="12"
r="10"></circle><polyline points="16 12 12 8 8 12"></polyline><line
x1="12" y1="16" x2="12" y2="8"></line></svg>



                </div>

            </div>
         </div>
      </div>
   </div>
</div>



<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script type="text/javascript">
    var $backToTop = $(".backTop");
    $backToTop.hide();
    $(window).on('scroll', function() {
      if ($(this).scrollTop() > 100) {
        $backToTop.fadeIn();
      } else {
        $backToTop.fadeOut();
      }
    });

    $backToTop.on('click', function(e) {
      $("html, body").animate({scrollTop: 0}, 500);
    });
</script>

@endsection
