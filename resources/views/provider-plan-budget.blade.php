@extends('layouts.app')

@section('content')
    <main class="main analytics-page">
        <div class="container-xxl">
            <div class="row">
                {{--                <div class="col-xl-6">--}}
                {{--                    <spendings-table></spendings-table>--}}
                {{--                </div>--}}

                <div class="col-xl-12">
                    <provider-plan-budget></provider-plan-budget>
                </div>
            </div>
        </div>
    </main>
@endsection
