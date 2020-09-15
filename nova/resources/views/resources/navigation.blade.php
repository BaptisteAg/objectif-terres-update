@if (count(\Laravel\Nova\Nova::availableResources(request())))
    <h3 class="flex items-center font-normal text-white mb-6 text-base no-underline">
        <svg class="sidebar-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
            <path fill="var(--sidebar-icon)"
                  d="M3 1h4c1.1045695 0 2 .8954305 2 2v4c0 1.1045695-.8954305 2-2 2H3c-1.1045695 0-2-.8954305-2-2V3c0-1.1045695.8954305-2 2-2zm0 2v4h4V3H3zm10-2h4c1.1045695 0 2 .8954305 2 2v4c0 1.1045695-.8954305 2-2 2h-4c-1.1045695 0-2-.8954305-2-2V3c0-1.1045695.8954305-2 2-2zm0 2v4h4V3h-4zM3 11h4c1.1045695 0 2 .8954305 2 2v4c0 1.1045695-.8954305 2-2 2H3c-1.1045695 0-2-.8954305-2-2v-4c0-1.1045695.8954305-2 2-2zm0 2v4h4v-4H3zm10-2h4c1.1045695 0 2 .8954305 2 2v4c0 1.1045695-.8954305 2-2 2h-4c-1.1045695 0-2-.8954305-2-2v-4c0-1.1045695.8954305-2 2-2zm0 2v4h4v-4h-4z"
            />
        </svg>
        <span class="sidebar-label">{{ __('Resources') }}</span>
    </h3>

    @foreach($navigation as $group => $resources)
        @if (count($groups) > 1)
            <h4 class="ml-8 mb-4 text-xs text-white-50% uppercase tracking-wide">{{ $group }}</h4>
        @endif

        <ul class="list-reset mb-8">
            @foreach($resources as $resource)
                <li class="leading-tight mb-4 ml-8 text-sm">
                    <router-link :to="{
                            name: 'index',
                            params: {
                            resourceName: '{{ $resource::uriKey() }}'
                            }
                            }" class="text-white text-justify no-underline dim">
                        {{ $resource::label() }}
                    </router-link>
                </li>
            @endforeach
        </ul>
    @endforeach
@endif

<h3 class="cursor-pointer flex items-center font-normal dim text-white mb-8 text-base no-underline">
    <a class=" font-normal dim text-white mb-2 text-base no-underline" href="{{route('administrator.usersByTerritories')}}">
        <svg class="sidebar-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
            <path fill="var(--sidebar-icon)"  d="M5.64 16.36a9 9 0 1 1 12.72 0l-5.65 5.66a1 1 0 0 1-1.42 0l-5.65-5.66zm11.31-1.41a7 7 0 1 0-9.9 0L12 19.9l4.95-4.95zM12 14a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm0-2a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"/>
        </svg>
        <span class="sidebar-label">Listes des utilisateurs par territoire</span>
    </a>

</h3>
<h3 class="cursor-pointer flex items-center font-normal dim text-white mb-8 text-base no-underline">
    <a class=" font-normal dim text-white mb-8 text-base no-underline" href="{{route('home')}}">
        <svg class="sidebar-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
            <path fill="var(--sidebar-icon)"
                  d="M19 6.41L8.7 16.71a1 1 0 1 1-1.4-1.42L17.58 5H14a1 1 0 0 1 0-2h6a1 1 0 0 1 1 1v6a1 1 0 0 1-2 0V6.41zM17 14a1 1 0 0 1 2 0v5a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V7c0-1.1.9-2 2-2h5a1 1 0 0 1 0 2H5v12h12v-5z"/>
        </svg>
        <span class="sidebar-label">Retour sur Objectif Terres</span>
    </a>

</h3>
