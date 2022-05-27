@extends('layouts.app')

@section('content')

<div class="container">
    @if (Route::has('logout'))
        <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
            @auth
                <a href="{{ route('logout') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Logout</a>
            @endauth
        </div>
    @endif

    <div class="py-5 text-center">
        <img class="d-block mx-auto mb-4" src="https://getbootstrap.com/docs/4.0/assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">
        <h2>Shorten Your Link</h2>
    </div>

    <div class="row">
        <div class="col-md-4 order-md-1 mb-4">
            <h4 class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-muted">Your shorten-link</span>
                <span class="badge badge-secondary badge-pill">{{ count($my_links) }}</span>
            </h4>
            <form class="card p-2" action="{{ route('shorten-url.store') }}" method="POST">
                @csrf
                <div class="input-group">
                    <input type="text" id="long_url" name="long_url" class="form-control" placeholder="Your Long Url">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-secondary">Create</button>
                    </div>
                </div>
                @error('long_url')
                    <span class="text-danger"> {{ $errors->first('long_url') }}</span>
                @enderror
                @error('store_error')
                    <span class="text-danger"> {{ $errors->first('store_error') }}</span>
                @enderror
                </form>
            <ul class="list-group mb-3" id="my_links">
                @foreach ($my_links as $link)
                <div onclick="display({{ $loop->iteration -1 }})">
                    <li class="list-group-item d-flex justify-content-between lh-condensed" type="button">
                        <div>
                            <h6 class="my-0">{{ $link->title }}</h6>
                            <small class="text-muted">{{ config('app.url') }}{{ $link->shorten_url }}</small>
                        </div>
                        <span class="text-muted">{{ $link->perclicks_count }} Clicks</span>
                    </li>
                </div>
                @endforeach
            </ul>
        </div>

        <div class="col-md-8 order-md-2">
            <h4 class="mb-3">Link Detail</h4>
            <form class="needs-validation" novalidate action="{{ route('shorten-url.update') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6 mb-3" hidden>
                        <input type="text" class="form-control" id="id" name="id_link" required>
                        @error('id_link')
                            <span class="text-danger"> {{ $errors->first('id') }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="title">title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                        @error('title')
                            <span class="text-danger"> {{ $errors->first('title') }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="shorten_url">shorten url</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon3">{{ config('app.url') }}</span>
                            </div>
                            <input type="text" class="form-control" id="shorten_url" name="shorten_url">
                            <div class="input-group-prepend">
                                <span class="input-group-text" type="button" onclick="copy_to_clipboard()">copy</span>
                            </div>
                            @error('shorten_url')
                                <span class="text-danger"> {{ $errors->first('shorten_url') }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="destination_url">destination url</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="destination_url" name="destination_url">
                    </div>
                    @error('destination_url')
                        <span class="text-danger"> {{ $errors->first('destination_url') }}</span>
                    @enderror
                </div>
                <hr class="mb-4">
                <button class="btn btn-primary btn-lg btn-block" type="submit" id="update_shorten_url">update</button>
                @error('update_error')
                    <span class="text-danger mr-2"> {{ $errors->first('update_error') }}</span>
                @enderror
            </form>

        </div>
    </div>

</div>

<script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script type="text/javascript">
    function display(detail){
        let link_detail = {!! json_encode($my_links) !!};
        document.getElementById('id').value = link_detail[detail].id;
        document.getElementById('title').value = link_detail[detail].title;
        document.getElementById('shorten_url').value = link_detail[detail].shorten_url;
        document.getElementById('destination_url').value = link_detail[detail].destination_url;
    }

    function copy_to_clipboard(){
        /* Get the text field */
        let short_url = document.getElementById("shorten_url");

        /* Select the text field */
        short_url.select();
        short_url.setSelectionRange(0, 99999); /* For mobile devices */

        let clipboard_link = '{{ config('app.url') }}' + short_url.value;

        /* Copy the text inside the text field */
        copyToClipboard(clipboard_link);

    }

    function copyToClipboard(text) {
    if (window.clipboardData && window.clipboardData.setData) {
        // Internet Explorer-specific code path to prevent textarea being shown while dialog is visible.
        return window.clipboardData.setData("Text", text);

    }
    else if (document.queryCommandSupported && document.queryCommandSupported("copy")) {
        var textarea = document.createElement("textarea");
        textarea.textContent = text;
        textarea.style.position = "fixed";  // Prevent scrolling to bottom of page in Microsoft Edge.
        document.body.appendChild(textarea);
        textarea.select();
        try {
            return document.execCommand("copy");  // Security exception may be thrown by some browsers.
        }
        catch (ex) {
            console.warn("Copy to clipboard failed.", ex);
            return prompt("Copy to clipboard: Ctrl+C, Enter", text);
        }
        finally {
            document.body.removeChild(textarea);
        }
    }
}
</script>


@endsection
