<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AjaxController extends Controller
{
    // DELETE
    public function delete($table, $id)
    {
        try {
            DB::table($table)->where('id', $id)->delete();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    // Toggle Status
    public function toggleStatus($table, $id)
    {
        $record = DB::table($table)->where('id', $id)->first();
        if (!$record)
            return response()->json(['success' => false]);

        $newStatus = $record->status == 'active' ? 'inactive' : 'active';
        DB::table($table)->where('id', $id)->update(['status' => $newStatus]);

        return response()->json(['success' => true, 'new_status_label' => ucfirst($newStatus)]);
    }

    // Live Search
    public function search($table, Request $request)
    {
        $q = $request->get('q', '');
        $results = DB::table($table)
            ->where('id', 'like', "%$q%")
            ->orWhere('name', 'like', "%$q%")
            ->limit(20)
            ->get();

        // map JSON selon table
        $json = $results->map(function ($item) use ($table) {
            return [
                'id' => $item->id,
                'reference' => $item->reference ?? '-',
                'user_name' => $item->name ?? '-',
                'session_title' => $item->title ?? '-',
                'status_label' => ucfirst($item->status ?? '-'),
                'note' => $item->note ?? null,
                'confirmed_at' => $item->confirmed_at ?? null,
                'cancelled_at' => $item->cancelled_at ?? null,
            ];
        });

        return response()->json($json);
    }
}