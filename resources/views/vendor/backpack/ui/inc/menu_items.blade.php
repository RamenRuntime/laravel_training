{{-- This file is used for menu items by any Backpack v7 theme --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>

<x-backpack::menu-item title="Notes" icon="la la-question" :link="backpack_url('note')" />
<x-backpack::menu-item title="Cards" icon="la la-question" :link="backpack_url('card')" />
<x-backpack::menu-item title="Sets" icon="la la-question" :link="backpack_url('set')" />
<x-backpack::menu-item title="Card sets" icon="la la-question" :link="backpack_url('card-set')" />