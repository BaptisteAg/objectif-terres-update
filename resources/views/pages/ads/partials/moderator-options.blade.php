@php
    $statusClasses = [
        \App\Models\AdStatus::APPROVE_ID => 'is-success',
        \App\Models\AdStatus::PENDING_ID => 'is-info',
        \App\Models\AdStatus::REFUSE_ID => 'is-danger',
        \App\Models\AdStatus::PENDING_MODERATION_STATUS_ID => 'is-warning',
    ];
    $buttons = [
        ['type' => 'is-success', 'action' => 'acceptAd', 'text' => 'Valider', 'status' => 'Validée'],
        ['type' => 'is-warning', 'action' => 'modifyAd', 'text' => 'Demander la modification', 'status' => 'En attente'],
        ['type' => 'is-danger', 'action' => 'rejectAd', 'text' => 'Refuser', 'status' => 'Refusée'],
    ];
@endphp

<div id="vue-moderation-modal">
    <vue-moderation-modal inline-template
                          :response-templates="{{json_encode($responseTemplates)}}"
                          :ad-id="{{$ad->id}}"
                          :attribution-ad-id="{{$ad->attributionAd?->id}}"
    >
        <div>
            <div class="bg-beige objT-border p-6 p-5-mobile m-3-mobile">
                <div class="is-flex is-justify-content-space-between">
                    <h3 class="title">Modérer l’annonce</h3>
                    @if(! is_null($ad->attributionAd->adStatus))
                        <b-tooltip
                                label="{{\App\Models\AdStatus::TOOLTIPS[$ad->attributionAd->adStatus->id]}}">
                            <div class="has-text-right-touch">Statut :
                                <b-tag type="{{ $statusClasses[$ad->attributionAd->adStatus->id] ?? 'is-info' }}"
                                       size="is-medium">{{$ad->attributionAd->adStatus->name}}</b-tag>
                            </div>
                        </b-tooltip>
                    @endif
                </div>
                @if($ad->attributionAd?->pending_update_since)
                    <b-message type="is-warning" class="mt-3">
                        Cette annonce était en ligne et a été modifiée par son auteur·e
                        le {{ $ad->attributionAd->pending_update_since->format('d/m/Y à H:i') }}.
                        Elle n'est plus visible du public en attendant votre re-validation.
                    </b-message>
                @endif
                <p>Consulter la <a href="/docs/OT_charte_oct2020.pdf">charte Objectif Terres</a> ainsi que la <a
                            href="/faq">FAQ</a> pour vous aider dans la modération de l’annonce.</p>
                <div class="buttons mt-3">
                    <b-button type="is-primary" @click="showPreModerationModal()" rounded>Modérer</b-button>
                    <b-button type="is-warning" @click="showHistoryModal()" rounded>Suivi de l’annonce</b-button>
                </div>
            </div>

            <b-modal
                    v-model="showPreModal"
                    has-modal-card
                    trap-focus
                    :destroy-on-hide="false"
                    aria-role="dialog"
                    aria-label="Pre moderation modal"
                    close-button-aria-label="Close"
                    aria-modal>
                <template #default="props">
                    <div class="bg-beige objT-border p-6 p-5-mobile">
                        <h3 class="title">Modérer l’annonce</h3>
                        <p>Choisissez l’action à effectuer sur cette annonce.</p>
                        <div class="buttons mt-5">
                            @foreach($buttons as $index => $button)
                                @if($isAdToModerate && $isLoggedUserModeratorAd || (!$isAdToModerate && $isLoggedUserModeratorAd && $ad->attributionAd->adStatus->name !== $button['status']))
                                    <b-button type="{{ $button['type'] }}"
                                              @click="showModerationModal('{{ $button['action'] }}')"
                                              rounded>{{ $button['text'] }}</b-button>
                                @endif
                                @if($index === 1)
                                    <b-button onclick="return confirm('Êtes vous sûr·e ?')" tag="a"
                                              href="{{  route('ads.archive', [ $ad->id]) }}"
                                              rounded>
                                        Archiver
                                    </b-button>
                                @endif
                                @if($index === 2)
                                    <b-button
                                            class="ml-8"
                                            href="{{ $isSupportRequest ? route('support-request.edit') : route('ads.edit', ["id" => $ad->id]) }}"
                                            tag="a" rounded>Modifier
                                    </b-button>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </template>
            </b-modal>

            <moderation-modal
                    v-if="showModal"
                    @close="showModerationModal(false)"
                    :moderation-choice="moderationChoice"
                    :select-options="selectOptions"
                    :form-url="formUrl"
                    :ad-id="adIdShow"
                    :attribution-ad-id="attributionAd"
                    accept-ad-message="{{\App\Models\AttributionAd::VALIDATION_MESSAGE}}"
                    :allow-to-create-response-template="{{auth()->user()->role >= 3 ? 'true' : 'false'}}"
                    :is-ad-partner="{{$ad->is_partner === 1 ? 'true' : 'false'}}"
            >
            </moderation-modal>

            <ad-history-modal
                    v-if="historyModalOpen"
                    :ad-id="adIdShow"
                    @close="historyModalOpen = false">
            </ad-history-modal>

        </div>
    </vue-moderation-modal>
</div>
<br>

