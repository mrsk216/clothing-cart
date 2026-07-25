<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Keep only the earliest payment per UTR so a unique index can be applied safely.
        $duplicates = DB::table('payments')
            ->select('utr_number')
            ->whereNotNull('utr_number')
            ->where('utr_number', '!=', '')
            ->groupBy('utr_number')
            ->havingRaw('COUNT(*) > 1')
            ->pluck('utr_number');

        foreach ($duplicates as $utr) {
            $ids = DB::table('payments')
                ->where('utr_number', $utr)
                ->orderBy('id')
                ->pluck('id');

            $ids->shift();
            if ($ids->isNotEmpty()) {
                foreach ($ids as $id) {
                    DB::table('payments')->where('id', $id)->update([
                        'utr_number' => $utr . '-dup-' . $id,
                    ]);
                }
            }
        }

        Schema::table('payments', function (Blueprint $table) {
            $sm = Schema::getConnection()->getSchemaBuilder();
            $indexes = collect($sm->getIndexes('payments'))->pluck('name');

            if ($indexes->contains('payments_utr_number_index')) {
                $table->dropIndex('payments_utr_number_index');
            }

            if (! $indexes->contains('payments_utr_number_unique')) {
                $table->unique('utr_number');
            }
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropUnique(['utr_number']);
            $table->index('utr_number');
        });
    }
};
