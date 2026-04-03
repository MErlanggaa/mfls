<?php

namespace App\Observers;

use App\Models\Nilai;
use App\Models\Daftar;

class NilaiObserver
{
    /**
     * Handle the Nilai "saved" event.
     */
    public function saved(Nilai $nilai): void
    {
        $this->recalculateAverages($nilai);
    }

    /**
     * Handle the Nilai "deleted" event.
     */
    public function deleted(Nilai $nilai): void
    {
        $this->recalculateAverages($nilai);
    }

    /**
     * Recalculate averages and update the Daftar model.
     */
    protected function recalculateAverages(Nilai $nilai): void
    {
        $peserta = $nilai->peserta;
        if (!$peserta || !$peserta->daftar) return;

        $daftar = $peserta->daftar;
        $nilais = $peserta->nilais()->get();

        $updateData = [];
        for ($sem = 1; $sem <= 6; $sem++) {
            $avgSem = $nilais->where('semester', $sem)->avg('nilai') ?? 0;
            $updateData["avg_semester_{$sem}"] = round($avgSem, 2);
        }

        $realAvg = $nilais->avg('nilai') ?? 0;
        $updateData['rata_rata_nilai'] = round($realAvg, 2);

        // This update will trigger GoogleSheetObserver on the Daftar model
        $daftar->update($updateData);
    }
}
