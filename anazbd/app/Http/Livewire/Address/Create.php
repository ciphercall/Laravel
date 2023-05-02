<?php

namespace App\Http\Livewire\Address;

use App\Models\BillingAddress;
use App\Models\City;
use App\Models\Division;
use App\Models\PostCode;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Jenssegers\Agent\Agent;
use Livewire\Component;

class Create extends Component
{
    public $address,$cities,$divisions,$areas,$modal=false,$selectedDivision,$selectedCity,$selectedArea;
    public $divisionChanged = false, $cityChanged = false;
    public  $userAddress = [
        "name" => "",
        "email" => "",
        "mobile" => "",
        "address_line_1" => "",
        "address_line_2" => "",
    ];

    protected $listeners = [
        'addressUpdated' => '$refresh'
    ];

    public function mount(){
        $this->address = BillingAddress::whereAuthUser()->latest()->first();
        if ($this->address){
            $this->selectedDivision = az_hash($this->address->division_id);
            $this->selectedCity = az_hash($this->address->city_id);
            $this->selectedArea = $this->address->post_code_id != null ? az_hash($this->address->post_code_id) : null;
        }

    }

    public function render()
    {
        $this->attachAddress();
        $agent = new Agent();
        if($agent->isMobile()){
            return view('livewire.address.create-mobile');
        }
        return view('livewire.address.create');
    }

    public function updateAddress()
    {
        $this->validate([
            'userAddress.name' => 'required|min:8',
            'userAddress.email' => "nullable|email",
            'userAddress.mobile' => "required|numeric|min:11",
            'userAddress.address_line_1' => "required|string",
            'userAddress.address_line_2' => "nullable|string",
            'selectedDivision' => 'required|string',
            'selectedCity' => 'required|string',
            'selectedArea' => 'required|string',
        ],[
            'selectedDivision.required' => 'Division Must be Selected.',
            'selectedDivision.string' => 'Division Must be a Valid Division.',
            'selectedCity.required' => 'City Must be Selected.',
            'selectedArea.required' => 'Area Must be Selected.',
            'selectedCity.string' => 'City Must be a Valid City.',
            'selectedArea.string' => 'Area Must be a Valid Area.',
            'userAddress.mobile.required' => 'Mobile Number is required.',
            'userAddress.mobile.min' => 'Mobile Number must be valid.',
            'userAddress.name' => 'Name is required.',
            'userAddress.address_line_1.required' => 'Address Line 1 is required.'
        ]);

        if($this->address != null){
            $this->address->name = $this->userAddress["name"];
            $this->address->email = $this->userAddress["email"];
            $this->address->mobile = $this->userAddress["mobile"];
            $this->address->address_line_1 = $this->userAddress["address_line_1"];
            $this->address->address_line_2 = $this->userAddress["address_line_2"];
            $this->address->division_id = az_unhash($this->selectedDivision) ?? $this->address->division_id;
            $this->address->city_id = az_unhash($this->selectedCity) ?? $this->address->city_id;
            $this->address->post_code_id = az_unhash($this->selectedArea) ?? $this->address->post_code_id;
            $this->address->update();
        }else{

            $this->address = BillingAddress::create([
                'user_id' => auth('web')->id(),
                'name' => $this->userAddress["name"],
                'email' => $this->userAddress["email"],
                'mobile' => $this->userAddress["mobile"],
                'address_line_1' => $this->userAddress["address_line_1"],
                'address_line_2' => $this->userAddress["address_line_2"],
                'division_id' => az_unhash($this->selectedDivision),
                'city_id' => az_unhash($this->selectedCity),
                'post_code_id' => az_unhash($this->selectedArea),
            ]);
        }
        try {
            $user = \auth('web')->user();
            $user->name = $this->address->name;
            $user->address_line_1 = $this->address->address_line_1;
            $user->address_line_2 = $this->address->address_line_2;
            $user->division_id = $this->address->division_id;
            $user->city_id = $this->address->city_id;
            $user->post_code_id = $this->address->post_code_id;
            $user->update();
        }catch (\Exception $exception){
            //
        }

        $this->modal = false;
        $this->emit('addressUpdated');
        $this->dispatchBrowserEvent("addressUpdated",['type'=>'success','message' => 'Address Updated.']);
    }
    public function openModal()
    {
        $this->modal = true;
        $this->bindWithAddress();
    }

    public function closeModal()
    {
        $this->modal = false;
    }

    private function bindWithAddress()
    {
        if($this->address != null){
            $this->userAddress["name"] = $this->address->name;
            $this->userAddress["email"] = $this->address->email;
            $this->userAddress["mobile"] = $this->address->mobile;
            $this->userAddress["division_id"] = $this->address->division_id;
            $this->userAddress["city_id"] = $this->address->city_id;
            $this->userAddress["area_id"] = $this->address->area_id;
            $this->userAddress["address_line_1"] = $this->address->address_line_1;
            $this->userAddress["address_line_2"] = $this->address->address_line_2;
        }

    }

    private function attachAddress(){
        $this->divisions = Division::get(['id','name']);
        if($this->selectedDivision){
            $this->cities = City::where('division_id',az_unhash($this->selectedDivision))->get();
        }else{
            $this->cities = City::where('division_id',$this->address->division_id ?? 3)->get();
        }
        if($this->selectedCity){
            $this->areas = PostCode::where('city_id',az_unhash($this->selectedCity))->get();
        }else{
            $this->areas =  PostCode::where('city_id',$this->address->city_id ?? 33)->get();
        }

        if ($this->divisionChanged == false && az_unhash($this->selectedDivision) != ($this->address->division_id ?? 3)){
            $this->divisionChanged = true;
            $this->selectedArea = null;
            $this->selectedCity = null;
        }
        if ($this->cityChanged == false && az_unhash($this->selectedCity) != ($this->address->city_id ?? 3) && $this->selectedCity != null){
            $this->cityChanged = true;
            $this->selectedArea = null;
        }
    }
}
