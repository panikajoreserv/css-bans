@extends('layouts.app')
@section('content')
    @if (session('success'))
        <x-alert type="success" :message="session('success')"/>
    @endif
    @if (session('error'))
        <x-alert type="danger" :message="session('error')"/>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-body">
                    <h5 class="card-title text-center mb-4">Add Mute</h5>
                    <form action="{{ route('mute.store') }}" method="POST">
                        @csrf
{{--                        disabled for future use--}}
{{--                        <div class="note note-info mb-3">--}}
{{--                            <strong>Note:</strong> You can Mute a player either by Steam ID or Player IP or by both.--}}
{{--                        </div>--}}
                        <div data-mdb-input-init class="form-outline mb-3">
                            <input type="number" class="form-control" id="player_steam_id" name="player_steam_id" required/>
                            <label class="form-label" for="player_steam_id">Player Steam ID</label>
                        </div>
                        <div data-mdb-input-init class="form-outline mb-3">
                            <label class="form-label" for="type">Type</label>
                            <select class="form-select" id="type" name="type">
                                <option value="GAG">GAG</option>
                                <option value="MUTE">MUTE</option>
                                <option value="SILENCE">SILENCE</option>
                            </select>
                        </div>
{{--                        disabled for future use once plugin supports--}}
{{--                        <div data-mdb-input-init class="form-outline mb-3">--}}
{{--                            <input type="text" class="form-control" id="player_ip" name="player_ip"/>--}}
{{--                            <label class="form-label" for="player_ip">Player IP</label>--}}
{{--                        </div>--}}
{{--                        <div data-mdb-input-init class="form-outline mb-3">--}}
{{--                            <input type="text" class="form-control" id="player_name" name="player_name"/>--}}
{{--                            <label class="form-label" for="player_name">Player Name (Required only if no steam id is specified)</label>--}}
{{--                        </div>--}}
                        <div data-mdb-input-init class="mb-3">
                            <label class="form-label" for="reason">Reason</label>
                            <textarea type="text" class="form-control" id="reason" name="reason" required></textarea>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="permanent" name="permanent">
                                <label class="form-check-label" for="permanent">
                                    Permanent (Never Expire)
                                </label>
                            </div>
                        </div>

                        <div data-mdb-input-init class="mb-3">
                            <label class="form-label" for="duration">Duration</label>
                            <input  type="datetime-local"  min="{{ date('Y-m-d\TH:i') }}" class="form-control active" id="duration" name="duration" required/>
                        </div>

                        <div data-mdb-input-init class="form-outline mb-3">
                            <select multiple="multiple" class="form-select" id="server_ids" name="server_ids[]" required>
                                <option value="">Select Servers</option>
                                @foreach($servers as $server)
                                    @if(\App\Helpers\PermissionsHelper::hasMutePermission($server->id))
                                        <option  value="{{ $server->id }}">{{ $server->hostname }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="mt-3">
                            <center> <button type="submit" class="btn btn-primary col-md-2 mx-auto">Add Mute</button></center>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@vite(['resources/js/mutes/add.ts'])
