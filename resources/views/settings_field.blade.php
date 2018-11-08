@isset($field['include_pre']) 
    @if(is_array($field['include_pre']) && count($field['include_pre']) > 0) 
        @include($field['include_pre'][0], count($field['include_pre']) > 1 ? $field['include_pre'][1] : [])
    @else
        @include($field['include_pre'])
    @endif
@endisset

@if($field['type'] == 'number')
    {{ Form::bsNumber($field_key, $field['value'], $field['args'] ?? [ 'placeholder' => $field['placeholder'] ?? null ], $field['label'], $field['help'] ?? null) }}
@elseif($field['type'] == 'select')
    {{ Form::bsSelect($field_key, $field['list'], $field['value'], [ 'placeholder' => $field['placeholder'] ?? null ], $field['label'], $field['help'] ?? null) }}
@else
    {{ Form::bsText($field_key, $field['value'], $field['args'] ?? [ 'placeholder' => $field['placeholder'] ?? null ], $field['label'], $field['help'] ?? null) }}
@endif

@isset($field['include_post']) 
    @if(is_array($field['include_post']) && count($field['include_post']) > 0) 
        @include($field['include_post'][0], count($field['include_post']) > 1 ? $field['include_post'][1] : [])
    @else
        @include($field['include_post'])
    @endif
@endisset