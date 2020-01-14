@extends('main')
@section('content')

    <!-- <template v-if="menu==2">
        <regiones-component></regiones-component>
    </template> -->
    <template v-if="menu==2">
        <regiones-component></regiones-component>
    </template>
    <template v-if="menu==3">
        <delegaciones-component></delegaciones-component>
    </template>

@endsection