@extends('fundraising::layouts.donors-donations')

@section('title', __('fundraising::fundraising.donation_management'))

@section('wrapped-content')

    <div id="app">
        @php
            $fields = [
                'first_name' => [
                    'label' => __('app.first_name'),
                    'sortable' => true,
                ],
                'last_name' => [
                    'label' => __('app.last_name'),
                    'sortable' => true,
                ],
                'company' => [
                    'label' => __('app.company'),
                    'sortable' => true,
                ],
                'street' =>  [
                    'label' => __('app.street'),
                    'class' => 'd-none d-sm-table-cell',
                ],
                'zip' =>  [
                    'label' => __('app.zip'),
                    'class' => 'd-none d-sm-table-cell',
                ],
                'city' => [
                    'label' => __('app.city'),
                    'class' => 'd-none d-sm-table-cell',
                    'sortable' => true,
                ],
                'country' => [
                    'label' => __('app.country'),
                    'class' => 'd-none d-sm-table-cell',
                    'sortable' => true,
                ],
                'email' => [
                    'label' => __('app.email'),
                    'class' => 'd-none d-sm-table-cell',
                ],
                'phone' => [
                    'label' => __('app.phone'),
                    'class' => 'd-none d-sm-table-cell',
                    'type' => 'tel',
                ],
                'language' => [
                    'label' => __('app.correspondence_language'),
                    'class' => 'd-none d-sm-table-cell',
                    'sortable' => true,
                ],
            ];
        @endphp
        <donors-table 
            id="donorsTable"
            :fields='@json($fields)'
            api-url="{{ route('api.fundraising.donors.index') }}"
            default-sort-by="first_name"
            empty-text="@lang('fundraising::fundraising.no_donors_found')"
            filter-placeholder="@lang('fundraising::fundraising.search_for_name_address_email_phone')..."
            :items-per-page="10"
            :tags='@json($tags)'
        ></donors-table>
    </div>
	
@endsection
