<div class="row m-2">
    <style>
        .modal-backdrop {
            z-index: -1;
        }

        input {
            border: none;
        }
    </style>

    <div class="col-12 mb-2 card rounded shadow-sm" style="z-index: 1;">
        @if($address != null)
            <div class="col text-right" style="margin-top:-12px; margin-right:-16px;">
                <button id="opened" wire:click="openModal" data-toggle="modal" data-target="#address_form"
                        style="border: none; width:10px; background:none"><i class="fa fa-pen"></i></button>
            </div>
            <p class="p-1" id="mod_dt_chk">Name: {{ $address->name }} <br>
                Email: {{ $address->email }} <br>
                Mobile: {{ $address->mobile }} <br>
                Address: {{ $address->completeAddress }}
            </p>
        @else
            <button id="opened" wire:click="openModal" data-toggle="modal" data-target="#address_form"
                    style="border: none; background:none"><i class="fa fa-plus"></i> Add Address
            </button>
        @endif
    </div>
    <div class="col-12 card rounded shadow-sm">
        @if($address != null)
            @livewire('checkout')
        @endif
    </div>
    <!-- Modal -->
    <div class="mt-5 modal fade @if($modal) show @endif" id="address_form" tabindex="-1" role="modal"
         aria-labelledby="address_form" aria-hidden="{{ $modal ? 'false' : 'true' }}"
         @if($modal) style="display: block" @endif>
        <div id="pop" class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="row pb-1">
                            <div class="col-3">
                                <label for="Name">Name:</label>
                            </div>
                            <div class="col">
                                <input type="text" class="border-bottom border-dark" wire:model.lazy="userAddress.name">
                                @error('userAddress.name')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="row pb-1">
                            <div class="col-3">
                                <label for="Name">Email:</label>
                            </div>
                            <div class="col">
                                <input type="text" class="border-bottom border-dark"
                                       wire:model.lazy="userAddress.email">
                                @error('userAddress.email')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="row pb-1">
                            <div class="col-3">
                                <label for="Name">Mobile:</label>
                            </div>
                            <div class="col">
                                <input type="text" class="border-bottom border-dark"
                                       wire:model.lazy="userAddress.mobile">
                                @error('userAddress.mobile')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="row pb-1">
                            <div class="col-3">
                                <label for="Name">Address:</label>
                            </div>
                            <div class="col">
                                <input type="text" placeholder="Line 1" class="border-bottom border-dark" name="email"
                                       wire:model.lazy="userAddress.address_line_1">
                                @error('userAddress.address_line_1')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                                <input type="text" placeholder="Line 2" class="border-bottom border-dark" name="email"
                                       wire:model.lazy="userAddress.address_line_2">
                                @error('userAddress.address_line_2')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="row pb-1">
                            <div class="col-3">
                                <label for="">Select Division</label>
                            </div>
                            <div class="col">
                                <select autocomplete="off" name="" wire:model="selectedDivision" class="form-control"
                                        id="">
                                    <option>Select Division</option>
                                    @forelse($divisions as $division)
                                        <option value="{{ az_hash($division->id) }}"
                                                @if(($address->division_id ?? 0) == $division->id) selected="selected" @endif>{{ $division->name }}</option>
                                    @empty

                                    @endforelse
                                </select>
                                @error('selectedDivision')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        @if($cities)
                            <div class="row pb-1">
                                <div class="col-3">
                                    <label for="">Select City</label>
                                </div>

                                <div class="col">
                                    <select autocomplete="off" name="" wire:model="selectedCity" class="form-control"
                                            id="">
                                        <option>Select City</option>
                                        @forelse($cities as $city)
                                            <option value="{{ az_hash($city->id) }}"
                                                    @if(($address->city_id ?? 0) == $city->id) selected="selected" @endif>{{ $city->name }}</option>
                                        @empty

                                        @endforelse
                                    </select>
                                    @error('selectedCity')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        @endif
                        @if($areas)
                            <div class="row pb-1">
                                <div class="col-3">
                                    <label for="">Select Area</label>
                                </div>
                                <div class="col">
                                    <select name="" wire:model="selectedArea" class="form-control" id="">
                                        <option>Select City</option>
                                        @forelse($areas as $area)
                                            <option value="{{ az_hash($area->id) }}"
                                                    @if(($address->post_code_id ?? 0) == $area->id) selected="selected" @endif>{{ $area->name }}</option>
                                        @empty

                                        @endforelse
                                    </select>
                                    @error('selectedArea')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="closeMod" type="button" class="btn btn-secondary" wire:click="closeModal"
                            data-dismiss="modal"><i
                            class="fa fa-times"></i></button>
                    <button id="btn_upd_addr" type="button" wire:click="updateAddress" class="btn btn-warning"><i
                            class="fa fa-save"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div id="addr_dialog"
         style="display: none; width: 100%;height: 100%;background-color: rgba(0,0,0,0.6);position: fixed;padding: 0;margin: 0;left: 0%;top: 0%;">
        <div
            style="width: 94%;height: 37%;background-color: lavender;position: fixed;top: 13%;left: 3%;border-radius: 20px;">
            <h2 style="color: #020310;line-height: 1.4;font-weight: 700;width: 89%;left: 7%;top: 18%;position: fixed;">
                সম্মানিত গ্রাহক, আপনার ডেলিভারি তথ্যগুলো পুরন করতে "+Add Address" এই আইকনটিতে ক্লিক করুন.
            </h2>
            <div
                style="width: 4%;height: 20%;background-color: lavender;position: fixed;left: 3%;top: 12%;border-radius: 18px 0px 0px 0px;"></div>
            <div
                style="width: 4%;height: 20%;background-color: lavender;position: fixed;right: 3%;top: 12%;border-radius: 0px 18px 0px 0px;"></div>
            <button onclick="cls_addr_dialog()"
                    style="position: fixed;top: 42%;left: 72%;width: 78px;height: 37px;border-radius: 11px;background-color: brown;">
                <h2>Close</h2></button>
        </div>
    </div>
</div>
@push('js')
    <script>
        $(document).ready(function () {
            var mod_dt_chk = $('#mod_dt_chk').text();
            if (mod_dt_chk) {
                // alert(mod_dt_chk);
                z_idx_rst();
            } else {
                $('html').css('overflow', 'hidden');
                $('#addr_dialog').fadeIn();
                // $('#btn_cash_on_delivery, #btn_pay_online').prop('disabled', true);
                $(document).scrollTop(0);
            }
        });

        function cls_addr_dialog() {
            $('#addr_dialog').fadeOut();
            z_idx_rst();
        }

        $('#btn_upd_addr').on('click', function () {
            $('#addr_dialog').fadeOut();
            z_idx_rst();
            $('#btn_cash_on_delivery, #btn_pay_online').prop('disabled', false);
        });
        $('#closeMod').on('click', function () {
            z_idx_rst();
        });
        $('#opened').on('click', function () {
            z_idx_rst();
        });
        $('#address_form').on('show.bs.modal', function (e) {
            $('.modal-dialog').modal('toggle');
        })

        function z_idx_rst() {
            $('html').css('overflow', 'auto');

        }
    </script>
@endpush
