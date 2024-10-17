@extends('default')

@section('title', 'Gestion des messages types | Objectif Terres')

@section('header')
	@if(auth()->user()->role >= 3)
		@include('components.supervisor-tabs')
	@elseif (auth()->user()->role ===2)
		@include('components.advisor-tabs')
	@endif
@endsection

@section('main-content')
	<div class="section " style="padding-top: 0px">
		<h1 class="title is-2 has-text-link has-text-centered">Gestion des messages types </h1>
		{{Form::open(['route'=>'responseTemplates.create', 'method'=>'post'])}}
		<div class="content ">
			<h3 class="title is-3 has-text-centered">Créer un nouveau message type</h3>
			<p class="subtitle has-text-centered">Les messages sont ajoutés pour tous les
				utilisateurs.</p>
			<div class="columns is-mobile is-centered">
				<div class="column is-half ">
					<p>
                        <span class="icon">
                            <i class="fas fa-info-circle has-text-info"></i>
                        </span>
						<span class="">Commencez le titre du message par Annonce ou Accompagnement pour faciliter le
                            rangement de ces réponses.</span>
					</p>
					<div class="field">
						<label class="label">Titre du message</label>
						<div class="control">
							<input name="title" required class="input" type="text"
								   placeholder="Saisir le titre du message">
						</div>
					</div>
					<div class="field">
						<label class="label">Contenu du message</label>
						<div class="control">
							<textarea class="textarea" name="content" required
									  placeholder="Saisir le contenu du message"></textarea>
						</div>
					</div>
					<div class="field">
						<p class="control">
							<button class="button is-link" type="submit">
                                <span class="icon is-small">
                                    <i class="fas fa-plus-circle"></i>
                                </span>
								<span>Créer un nouveau message type</span>
							</button>
						</p>
					</div>
				</div>
			</div>
		</div>
		{{Form::close()}}
		<br>
		<br>
		<div class="content">
			<h5 class="title is-5 has-text-centered">Liste des messages types</h5>
			@if($responseTemplates->count() === 0)
				<p class="has-text-centered">Aucun message type trouvée</p>
			@else
				<div id="response-template-dashboard" class="columns is-centered is-mobile">
					<response-template-page inline-template>
						<div class="column is-10  ">
							<div class="columns is-center is-mobile response-templates-header-container">
								<div class="column is-2">Titre du message</div>
								<div class="column is-three-quarters">Contenu du message</div>
								<div class="column"></div>
							</div>
							@foreach($responseTemplates as $response)
								<div class="columns is-center is-mobile response-templates-container">
									<template v-if="responseTemplateToModify === {{$response->id}}">
										<div class="column is-11">
											{!! Form::open(['route' => 'responseTemplates.edit', 'method'=>'post']) !!}
											<div class="field is-horizontal">
												<div class="field-body">
													<div class="field is-narrow ">
														<div class="control">
															<input class="input" type="text" name="title"
																   value="{{$response->title}}">
														</div>
													</div>
													<div class="field ">
														<div class="control is-expanded">
															<input type="hidden" name="response_template_id"
																   value="{{$response->id}}">
															<textarea class="textarea"
																	  name="content"
																	  placeholder="Remplissez...">{{$response->content}}</textarea>
														</div>
														<div class="field is-grouped is-narrow mt-15">
															<div class="control">
																<button type="submit"
																		class="button is-link">
                                                                    <span class="icon">
                                                                        <i class="fas fa-check"></i>
                                                                    </span>
																	<span>Valider</span>
																</button>
															</div>
															<div class="control">
																<button v-on:click="modifyResponseTemplate(0)"
																		class="button is-link is-light">
                                                                    <span class="icon">
                                                                        <i class="fas fa-times"></i>
                                                                    </span>
																	<span>Annuler</span>
																</button>
															</div>
														</div>
													</div>

												</div>
											</div>
											{!! Form::close() !!}
										</div>
									</template>
									<template v-else>
										<div class="column is-2">{{$response->title}} <br><br><small><i>Créé le {{$response->created_at}}</i></small></div>
										<div class="column is-8 ">
											<p>
												@php
													echo html_entity_decode($response->content)
												@endphp
											</p>
										</div>
									</template>
									<div class="column ">
										<div v-if="responseTemplateToModify === {{$response->id}}">
											<button v-on:click="modifyResponseTemplate(0)"
													class="is-size-6 is-pulled-right has-text-link"
													style="border: none; background: transparent">
												<a>
                                                    <span class="icon">
                                                        <i class="fas fa-times"></i>
                                                    </span>
													<span>Annuler</span>
												</a>
											</button>
										</div>
										<div v-else>
											<button @click="modifyResponseTemplate({{$response->id}})"
													class="is-size-6 is-pulled-right has-text-link"
													style="border: none; background: transparent">
												<a>
                                                    <span class="icon">
                                                        <i class="fas fa-pen"></i>
                                                    </span>
													<span>Modifier</span>
												</a>
											</button>
										</div>
										{!! Form::open(['route' => 'responseTemplates.delete', 'method'=>'post', 'id' => 'delete-response'. $response->id]) !!}
											<input type="hidden" name="response_template_id"
												   value="{{$response->id}}">
											<a type="submit" class="is-pulled-right" onclick="confirm('Êtes vous sur de vouloir supprimer ?') && document.getElementById('delete-response{{$response->id}}').submit()">
												<span class="icon">
													<i class="fas fa-trash-alt"></i>
												</span>
												<span>Supprimer</span>
											</a>
											@include('pages.responseTemplates.partials.response-templates-validation-modal')
										{!! Form::close() !!}
									</div>
								</div>
							@endforeach
						</div>
					</response-template-page>
				</div>
			@endif
		</div>
	</div>
@endsection

@section('script')
@endsection
