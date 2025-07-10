<div>
    <div class="modal-header" style="border-color: var(--orange);border-width: 4px">
        @foreach ($data as $d)
            <h1>[{{ $d->type . $d->score }}] {{ $d->name }}</h1>
        @endforeach
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body" id="modal-story-body">
        <h2> Scope of Work </h2>
        @foreach ($data2 as $d)
            <h5>
                <ul>
                    <li> {{ $d->M_sow->sow }} </li>
                </ul>
            </h5>
        @endforeach
        <br>
        <h2> Description </h2>
        @foreach ($data as $d)
            <div> {!! $d->description !!} </div>
        @endforeach
        <br>
        <h2> Attachments </h2>
        @foreach ($data_pdf as $d)
            <tr>
                <td>

                    <span>
                        <img src="/images/pdf.png" height="40" width="30">
                        {{ $d->attachment }}
                    </span>
                    <br>
                    <a href="/docs/{{ $d->attachment }}" target="_blank" style="padding-left: 25px">View</a>
                    <a href="/download/{{ $d->attachment }}" style="padding-left: 25px">Download<a>
                            <br><br>
                </td>
            </tr>
        @endforeach
        @foreach ($data_images as $d)
            <tr>
                <td>
                    <a href="{{ url($d->attachment) }}"
                        onclick="window.open(this.href, '_blank', 'left=20,top=20,width=500,height=500,toolbar=1,resizable=0'); return false;">
                        <img src="{{ $d->attachment }}" width="100%" height="100%">
                    </a>
                    <br><br>
                </td>
            </tr>
        @endforeach
    </div>
</div>


