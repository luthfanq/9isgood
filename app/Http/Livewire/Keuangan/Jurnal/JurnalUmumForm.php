<?php

namespace App\Http\Livewire\Keuangan\Jurnal;

use App\Haramain\Repository\Jurnal\JurnalUmumRepository;
use App\Models\Keuangan\Akun;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Livewire\Component;

class JurnalUmumForm extends Component
{
    public function render()
    {
        return view('livewire.keuangan.jurnal.jurnal-umum-form');
    }

    protected $listeners = [
        'set_akun'
    ];

    public $data_detail = [];

    public $update = false, $mode = 'create';
    public $indexDetail;

    // status debet kredit
    public $debetKredit;

    // variabel untuk jurnal umum
    public $jurnal_umum_id;
    public $tujuan;
    public $tgl_jurnal;
    public $is_persediaan_awal = false;
    public $keterangan;

    // variabel untuk detail
    public $akun_id, $akun_kode, $akun_nama, $nominal_debet, $nominal_kredit;

    // validate
    protected $rules =[
        'akun_nama'=>'required',
        'nominal_debet'=>'nullable|integer',
        'nominal_kredit'=>'nullable|integer'
    ];

    public function mount($jurnalUmumId = null)
    {
        $this->tgl_jurnal = tanggalan_format(now('ASIA/JAKARTA'));
    }

    public function set_akun(Akun $akun)
    {
        $this->akun_id = $akun->id;
        $this->akun_kode = $akun->kode;
        $this->akun_nama = $akun->deskripsi;
    }

    public function resetForm()
    {
        $this->reset(['akun_id', 'akun_nama', 'akun_kode', 'nominal_debet', 'nominal_kredit']);
    }

    public function addLine()
    {
        $this->validate();
        //dd($this->akun_nama);
        $this->data_detail[] = [
            'akun_id'=>$this->akun_id,
            'akun_nama'=>$this->akun_nama,
            'akun_kode'=>$this->akun_kode,
            'nominal_debet'=>$this->nominal_debet,
            'nominal_kredit'=>$this->nominal_kredit
        ];
        $this->resetForm();
    }

    public function editLine($index)
    {
        $this->update = true;
        $this->indexDetail = $index;
        $this->akun_id = $this->data_detail [$index]['akun_id'];
        $this->akun_nama = $this->data_detail [$index]['akun_nama'];
        $this->nominal_debet = $this->data_detail [$index]['nominal_debet'];
        $this->nominal_kredit = $this->data_detail [$index]['nominal_kredit'];
    }

    public function updateLine()
    {
        $this->validate();
        $index = $this->indexDetail;
        $this->data_detail [$index]['akun_id'] = $this->akun_id;
        $this->data_detail [$index]['akun_nama'] = $this->akun_nama;
        $this->data_detail [$index]['nominal_debet'] = $this->nominal_debet;
        $this->data_detail [$index]['nominal_kredit'] = $this->nominal_kredit;
        $this->update = false;
        $this->resetForm();
    }

    public function destroyLine($index)
    {
        unset($this->data_detail[$index]);
        $this->data_detail = array_values($this->data_detail);
    }

    protected function validateData()
    {
        return $this->validate([
            'tujuan'=>'required',
            'tgl_jurnal'=>'required|date_format:d-M-Y',
            'is_persediaan_awal'=>'required',
            'data_detail'=>'required',
            'keterangan'=>'nullable|string',
        ]);
    }

    public function store()
    {
        // validation initiate
        $total_debet = array_sum(array_column($this->data_detail, 'nominal_debet'));
        $total_kredit = array_sum(array_column($this->data_detail, 'nominal_kredit'));
        $status = true;

        // check status
        if ($total_debet != $total_kredit){
            $status = false;
            session()->flash('message', 'Jumlah Debet dan Kredit Tidak Sama');
        }

        // jika status true, bisa disimpan ke database
        if ($status){
            \DB::beginTransaction();
            try {
                (new JurnalUmumRepository())->store((object)$this->validateData());
                \DB::commit();
                return redirect()->to('/keuangan/jurnal/umum');
            } catch (ModelNotFoundException $e){
                session()->flash('message', $e);
                \DB::rollBack();
            }
        }
        return null;
    }

    public function update()
    {
        // validation initiate
        $total_debet = array_sum(array_column($this->data_detail, 'nominal_debet'));
        $total_kredit = array_sum(array_column($this->data_detail, 'nominal_kredit'));
        $status = true;

        // check status
        if ($total_debet != $total_kredit){
            $status = false;
            session()->flash('message', 'Jumlah Debet dan Kredit Tidak Sama');
        }

        // jika status true, bisa disimpan ke database
        if ($status){
            \DB::beginTransaction();
            try {
                (new JurnalUmumRepository())->update((object)$this->validateData());
                \DB::commit();
                return redirect()->to('/keuangan/jurnal/umum');
            } catch (\Exception $e){
                \DB::rollBack();
            }
        }
        return null;
    }
}
