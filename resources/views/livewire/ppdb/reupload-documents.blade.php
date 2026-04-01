<div>
    @if($student && $student->status === 'rejected')
        <!-- Re-upload Trigger Button -->
        <div class="mt-6 bg-amber-50 border border-amber-200 rounded-xl p-5">
            <div class="flex items-start gap-3">
                <svg class="w-6 h-6 text-amber-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                </svg>
                <div class="flex-1">
                    <h4 class="text-sm font-bold text-amber-800 mb-1">Perbaiki Pendaftaran</h4>
                    <p class="text-sm text-amber-700 mb-3">Anda dapat mengunggah ulang dokumen yang diperlukan dan mengajukan kembali pendaftaran.</p>
                    <button wire:click="openModal" class="inline-flex items-center px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white text-sm font-semibold rounded-lg shadow-sm transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                        </svg>
                        Upload Ulang Dokumen
                    </button>
                </div>
            </div>
        </div>

        <!-- Re-upload Modal -->
        @if($showModal)
            <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <!-- Backdrop -->
                    <div class="fixed inset-0 bg-gray-500/75 transition-opacity" wire:click="closeModal"></div>

                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                    <!-- Modal Panel -->
                    <div class="relative inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                        <div class="bg-white px-6 pt-6 pb-4">
                            <div class="flex items-center justify-between mb-6">
                                <div>
                                    <h3 class="text-xl font-bold text-gray-900" id="modal-title">Upload Ulang Dokumen</h3>
                                    <p class="text-sm text-gray-500 mt-1">Pilih dokumen yang ingin Anda ganti. File lama akan otomatis terhapus.</p>
                                </div>
                                <button wire:click="closeModal" class="text-gray-400 hover:text-gray-500 p-1">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                </button>
                            </div>

                            <form wire:submit="reupload" class="space-y-5">
                                <!-- KK -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Kartu Keluarga (KK)</label>
                                    <input type="file" wire:model="kk_file" accept=".jpg,.jpeg,.png,.pdf"
                                           class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
                                    @if(isset($documents['kk']))
                                        <p class="text-xs text-gray-400 mt-1">File saat ini: {{ $documents['kk']->original_name }}</p>
                                    @endif
                                    @error('kk_file') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                <!-- Akta -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Akta Kelahiran</label>
                                    <input type="file" wire:model="akta_file" accept=".jpg,.jpeg,.png,.pdf"
                                           class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
                                    @if(isset($documents['akta_kelahiran']))
                                        <p class="text-xs text-gray-400 mt-1">File saat ini: {{ $documents['akta_kelahiran']->original_name }}</p>
                                    @endif
                                    @error('akta_file') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                <!-- Foto -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Pas Foto (3x4)</label>
                                    <input type="file" wire:model="photo_file" accept=".jpg,.jpeg,.png"
                                           class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
                                    @if(isset($documents['foto']))
                                        <p class="text-xs text-gray-400 mt-1">File saat ini: {{ $documents['foto']->original_name }}</p>
                                    @endif
                                    @error('photo_file') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                <!-- Ijazah -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Ijazah (Opsional)</label>
                                    <input type="file" wire:model="ijazah_file" accept=".jpg,.jpeg,.png,.pdf"
                                           class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
                                    @if(isset($documents['ijazah']))
                                        <p class="text-xs text-gray-400 mt-1">File saat ini: {{ $documents['ijazah']->original_name }}</p>
                                    @endif
                                    @error('ijazah_file') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                <!-- Upload progress -->
                                <div wire:loading wire:target="kk_file, akta_file, photo_file, ijazah_file"
                                     class="flex items-center gap-2 text-sm text-primary-600">
                                    <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                    </svg>
                                    Mengupload file...
                                </div>

                                <!-- Actions -->
                                <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                                    <button type="button" wire:click="closeModal" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                        Batal
                                    </button>
                                    <button type="submit" class="px-6 py-2 text-sm font-bold text-white bg-primary-600 hover:bg-primary-700 rounded-lg shadow-sm transition-colors"
                                            wire:loading.attr="disabled" wire:loading.class="opacity-50">
                                        <span wire:loading.remove wire:target="reupload">Upload & Ajukan Ulang</span>
                                        <span wire:loading wire:target="reupload">Memproses...</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endif
</div>
