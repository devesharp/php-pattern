/*
        |--------------------------------------------------------------------------
        | Generate Mocks
        |--------------------------------------------------------------------------
        */
{!!  $headerFnTest !!}
@if(!empty($user_token))
        ${{ $userVariable }}->access_token = JWTAuth::fromUser(${{ $userVariable }});
@endif

@if(empty($fieldsUsedOnResource))
@if(!empty($create))
        $resource = {{ $resourceName }}::factory()->create();
@else
        $resourceData = {{ $resourceName }}::factory()->{!! !empty($forDocs) ? 'bodyForDocs()' : 'bodyForRequest()->raw()' !!};
@endif
@else
@foreach($fieldsUsedOnResource as $fieldRelationTest)
@if(!$fieldRelationTest['usedUserRelation'] && !$fieldRelationTest['alreadyBeenDefined'])
        ${{$fieldRelationTest['variable']}} = {{$fieldRelationTest['resourceName']}}::factory()->create();
@endif
@endforeach
@if(!empty($create))
        $resource = {{ $resourceName }}::factory([
@else
        $resourceData = {{ $resourceName }}::factory([
@endif
@foreach($fieldsUsedOnResource as $fieldRelationTest)@if(!$fieldRelationTest['valueOnUser'])
            '{{$fieldRelationTest['localKey']}}' => ${{$fieldRelationTest['variable']}}->{{$fieldRelationTest['key']}},
@endif
@endforeach
@if(!empty($create))
@if(!empty($search))
        ])->count(5)->create();
@else
        ])->create();
@endif
@else
        ])->{!! !empty($forDocs) ? 'bodyForDocs()' : 'bodyForRequest()->raw()' !!};
@endif
@endif
@if(!empty($update))
@if(empty($fieldsUsedOnResource))
        $resourceData = {{ $resourceName }}::factory()->{!! !empty($forDocs) ? 'bodyForDocs()' : 'bodyForRequest()->raw()' !!};
@else
        $resourceData = {{ $resourceName }}::factory([
@foreach($fieldsUsedOnResource as $fieldRelationTest)
                '{{$fieldRelationTest['localKey']}}' => ${{$fieldRelationTest['variable']}}->{{$fieldRelationTest['key']}},
@endforeach
        ])->{!! !empty($forDocs) ? 'bodyForDocs()' : 'bodyForRequest()->raw()' !!};
@endif
@endif