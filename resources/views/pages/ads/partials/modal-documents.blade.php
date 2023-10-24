@if($ad->nonImageDocuments->count() > 0)
    <modal
            title="Documents joints au projet"
            subtitle="Choisissez le fichier à consulter"
            button-icon="download"
            button-label="Documents"
            :is-responsive="true"
    >
        @foreach($ad->nonImageDocuments as $document)
            <b-button rounded tag="a" target="_blank"
                      href="{{app('url')->assetFrom('https://objectif-terres.org', $document->path)}}"
                      icon-left="@php
                            if ($document->type === "application/pdf") {
                                echo 'file-pdf-box';
                            } elseif ($document->type === "application/msword") {
                                echo 'file-word-box';
                            } else {
                                echo 'file-image';
                            }
                            @endphp">
                {{$document->name}}
            </b-button>
        @endforeach
    </modal>
@endif
