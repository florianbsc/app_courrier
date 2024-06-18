<form method="POST" action="{{ route('depot_scan_courrier', ['id_courrier' => $courrier->id_courrier]) }}" enctype='multipart/form-data'>
    @csrf
    <label for="scan_courrier_{{ $courrier->id_courrier }}" class="upload-label">
        <input type="hidden" name="id_courrier" value="{{ $courrier->id_courrier }}">
        <input id="scan_courrier_{{ $courrier->id_courrier }}" name="scan_courrier" class="courrier-file" type="file" aria-label="Téléverser un scan de courrier">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-upload" viewBox="0 0 16 16">
            <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5"/>
            <path d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708z"/>
        </svg>
    </label>     
</form>
