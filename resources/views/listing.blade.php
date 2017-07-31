<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>

        <title>Directory listing of {{ $dir }}</title>
        <link rel="shortcut icon" href="{{ asset('img/folder.png') }}">

        <!-- STYLES -->
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">

        <!-- SCRIPTS -->
        <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>

        <!-- FONTS -->
        <link rel="stylesheet" type="text/css"  href="//fonts.googleapis.com/css?family=Cutive+Mono">

        <!-- META -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

    </head>

    <body>

        <div id="page-navbar" class="navbar navbar-default navbar-fixed-top">
            <div class="container">

                <p class="navbar-text">
                    @foreach ($breadcrumbs as $breadcrumb)
                        @if ($breadcrumb != end($breadcrumbs))
                            <a class="breadcrumb" href="{{ $breadcrumb['link'] }}">{{ $breadcrumb['text'] }}</a>
                        @else
                            {{ $breadcrumb['text'] }}
                        @endif
                    @endforeach
                </p>

                <div class="navbar-right">

                    <ul id="page-top-nav" class="nav navbar-nav">
                        <li>
                            <a href="javascript:void(0)" id="page-top-link">
                                <i class="fa fa-arrow-circle-up fa-lg"></i>
                            </a>
                        </li>
                    </ul>

                    @if ($canZip)
                        <ul id="page-top-download-all" class="nav navbar-nav">
                            <li>
                                <a href="{{ route('list', $dir) }}?zip=1" id="download-all-link">
                                    <i class="fa fa-download fa-lg"></i>
                                </a>
                            </li>
                        </ul>
                    @endif

                </div>

            </div>
        </div>

        <div id="page-content" class="container">

            <div id="directory-list-header">
                <div class="row">
                    <div class="col-md-7 col-sm-6 col-xs-10">File</div>
                    <div class="col-md-2 col-sm-2 col-xs-2 text-right">Size</div>
                    <div class="col-md-3 col-sm-4 hidden-xs text-right">Last Modified</div>
                </div>
            </div>

            <ul id="directory-listing" class="nav nav-pills nav-stacked">

                @foreach ($files as $file)
                    <li data-name="{{ $file['name'] }}" data-href="{{ $file['url'] }}">
                        <a href="{{ $file['url'] }}" class="clearfix" data-name="{{ $file['name'] }}">


                            <div class="row">
                                <span class="file-name col-md-7 col-sm-6 col-xs-9">
                                    <i class="fa {{ $file['type'] 	}} fa-fw"></i>
                                    {{ $file['name'] }}
                                </span>

                                <span class="file-size col-md-2 col-sm-2 col-xs-3 text-right">
                                    {{ $file['size'] }}
                                </span>

                                <span class="file-modified col-md-3 col-sm-4 hidden-xs text-right">
                                    {{ $file['mod_time'] }}
                                </span>
                            </div>

                        </a>

                        @if (@$file['type'] === 'file')

                            <a href="javascript:void(0)" class="file-info-button">
                                <i class="fa fa-info-circle"></i>
                            </a>

                        @endif

                    </li>
                @endforeach

            </ul>
        </div>

        <div id="file-info-modal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">@{{modal_header}}</h4>
                    </div>

                    <div class="modal-body">

                        <table id="file-info" class="table table-bordered">
                            <tbody>

                                <tr>
                                    <td class="table-title">MD5</td>
                                    <td class="md5-hash">@{{md5_sum}}</td>
                                </tr>

                                <tr>
                                    <td class="table-title">SHA1</td>
                                    <td class="sha1-hash">@{{sha1_sum}}</td>
                                </tr>

                            </tbody>
                        </table>

                    </div>

                </div>
            </div>
        </div>

    </body>

</html>

