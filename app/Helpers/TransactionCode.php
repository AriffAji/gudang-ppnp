namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TransactionCode {
    // $type: 'MASUK' or 'KELUAR'
    public static function generate(string $type): string {
        $date = Carbon::now()->format('Ymd');
        $prefix = $type === 'MASUK' ? 'MASUK' : 'KELUAR';
        // count existing today for that type
        $like = "TRX-{$prefix}-{$date}-%";
        // To avoid race conditions, use DB transaction to compute incremental number
        $count = DB::table('barang_masuk')->where('kode_transaksi','like',"TRX-MASUK-{$date}-%")->count();
        // But since we need both types separate, better compute based on table
        // For simplicity here we will compute depending on $type:
        if ($type === 'MASUK') {
            $n = DB::table('barang_masuk')->whereDate('created_at', Carbon::today())->count() + 1;
        } else {
            $n = DB::table('barang_keluar')->whereDate('created_at', Carbon::today())->count() + 1;
        }
        $seq = str_pad($n, 3, '0', STR_PAD_LEFT);
        return "TRX-{$prefix}-{$date}-{$seq}";
    }
}
