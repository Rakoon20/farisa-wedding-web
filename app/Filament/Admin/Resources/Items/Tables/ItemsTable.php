<?php

namespace App\Filament\Admin\Resources\Items\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Actions\BulkActionGroup as ActionsBulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction as ActionsDeleteBulkAction;
use Filament\Actions\EditAction as ActionsEditAction;
use Filament\Notifications\Notification;
use Illuminate\Database\QueryException;

class ItemsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make("row_number")
                    ->label("No")
                    ->getStateUsing(function ($record, $rowLoop) {
                        return $rowLoop->iteration;
                    }),

                TextColumn::make("code")
                    ->label("Kode")
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage("Kode tersalin"),

                TextColumn::make("name")
                    ->label("Nama Item")
                    ->searchable()
                    ->sortable(),

                TextColumn::make("description")
                    ->label("Deskripsi")
                    ->limit(50)
                    ->toggleable()
                    ->default('-'),

                TextColumn::make("price")
                    ->label("Harga")
                    ->money('IDR', locale: 'id')
                    ->sortable()
                    ->alignment('right'),

                IconColumn::make("is_active")
                    ->label("Aktif")
                    ->boolean(),

                TextColumn::make("created_at")
                    ->label("Dibuat")
                    ->dateTime("d M Y")
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make("updated_at")
                    ->label("Diperbarui")
                    ->dateTime("d M Y")
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TernaryFilter::make("is_active")
                    ->label("Status Aktif")
                    ->placeholder("Semua")
                    ->trueLabel("Aktif")
                    ->falseLabel("Tidak Aktif"),
            ])
            ->recordActions([
                ActionsEditAction::make()
                    ->label("Edit"),
                DeleteAction::make()
                    ->label("Hapus")
                    ->successNotification(null)
                    ->modalDescription("Apakah Anda yakin ingin menghapus item ini? Tindakan ini tidak dapat dibatalkan.")
                    ->modalSubmitActionLabel("Hapus")
                    ->modalCancelActionLabel("Batal")
                    ->action(function ($record) {
                        try {
                            $record->delete();
                            Notification::make()
                                ->success()
                                ->title("Berhasil")
                                ->body("Item {$record->name} berhasil dihapus.")
                                ->send();
                        } catch (QueryException $e) {
                            if ($e->errorInfo[1] == 1451) {
                                Notification::make()
                                    ->danger()
                                    ->title("Tidak Dapat Menghapus")
                                    ->body("Item '{$record->name}' masih digunakan di pesanan. Hapus atau ubah pesanan terlebih dahulu.")
                                    ->send();
                            } else {
                                Notification::make()
                                    ->danger()
                                    ->title("Gagal Menghapus")
                                    ->body("Terjadi kesalahan: " . $e->getMessage())
                                    ->send();
                            }
                        }
                    }),
            ])
            ->bulkActions([
                ActionsBulkActionGroup::make([
                    ActionsDeleteBulkAction::make()
                        ->label("Hapus Item Terpilih")
                        ->successNotification(null)
                        ->modalDescription("Apakah Anda yakin ingin menghapus item-item yang dipilih? Tindakan ini tidak dapat dibatalkan.")
                        ->modalSubmitActionLabel("Hapus")
                        ->modalCancelActionLabel("Batal")
                        ->action(function ($records) {
                            $failedRecords = [];
                            foreach ($records as $record) {
                                try {
                                    $record->delete();
                                } catch (QueryException $e) {
                                    if ($e->errorInfo[1] == 1451) {
                                        $failedRecords[] = $record->name;
                                    } else {
                                        throw $e;
                                    }
                                }
                            }
                            if (count($failedRecords) > 0) {
                                $names = implode(", ", $failedRecords);
                                Notification::make()
                                    ->danger()
                                    ->title("Sebagian Gagal Dihapus")
                                    ->body("Item berikut masih digunakan di pesanan: {$names}")
                                    ->send();
                            } else {
                                Notification::make()
                                    ->success()
                                    ->title("Berhasil")
                                    ->body("Semua item yang dipilih berhasil dihapus.")
                                    ->send();
                            }
                        }),
                ]),
            ]);
    }
}
