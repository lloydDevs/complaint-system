@props(['code'])

<div id="ticketModal" class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/80 backdrop-blur-md p-4">
    <div
        class="bg-white dark:bg-gray-900 max-w-lg w-full rounded-[2.5rem] overflow-hidden shadow-2xl border border-white/10 animate-in fade-in zoom-in duration-300">

        <!-- The Visual Ticket (This is what gets captured) -->
        <div id="captureArea" class="p-6 bg-white">
            <div id="captureTicket"
                class="p-8 bg-white text-gray-900 relative border-[3px] border-emerald-600 rounded-[2rem]">
                <div class="flex justify-between items-start mb-8">
                    <div>
                        <h2 class="text-xl font-black text-emerald-600 uppercase tracking-tighter">DA-MIMAROPA</h2>
                        <p class="text-[8px] font-black text-gray-400 uppercase tracking-[0.2em]">Official Secure Ticket
                        </p>
                    </div>
                    <div class="bg-emerald-600 text-white p-1.5 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04a11.3 11.3 0 00-1.18 4.444c0 1.636.347 3.192.976 4.594a9.913 9.913 0 002.321 3.242 11.954 11.954 0 007.32 3.243 11.954 11.954 0 007.32-3.243 9.913 9.913 0 002.321-3.242c.629-1.402.976-2.958.976-4.594a11.3 11.3 0 00-1.18-4.444z">
                            </path>
                        </svg>
                    </div>
                </div>

                <div
                    class="py-6 border-y-2 border-dashed border-gray-100 flex flex-col items-center justify-center mb-6">
                    <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Tracking Code</p>
                    <p class="text-2xl font-mono font-black text-emerald-600 tracking-widest">
                        {{ $code ?? 'N/A' }}
                    </p>

                    <!-- NEW: Instruction Note inside the captured ticket -->
                    <p class="mt-4 text-[9px] text-center text-gray-400 leading-relaxed max-w-[200px]">
                        Save this tracking number for your reference so you can track your progress.
                    </p>
                </div>

                <div class="flex justify-between items-center text-[10px] font-bold text-gray-500 uppercase">
                    <span>Issued: {{ now()->format('M d, Y') }}</span>
                    <span class="text-emerald-600">Status: Verified</span>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="p-6 bg-gray-50 dark:bg-gray-800/50 flex flex-col gap-3">
            {{-- Optional: Add another notice here if you want it outside the image --}}
            <button type="button" onclick="downloadTicketImage()" id="downloadBtn"
                class="w-full py-4 bg-emerald-600 hover:bg-emerald-500 text-white text-[11px] font-black uppercase tracking-[0.2em] rounded-2xl transition-all shadow-lg active:scale-95">
                Save to Device
            </button>
            <button type="button" onclick="document.getElementById('ticketModal').remove()"
                class="w-full py-3 text-gray-400 text-[10px] font-bold uppercase tracking-widest hover:text-gray-600 transition-colors">
                Dismiss
            </button>
        </div>
    </div>
</div>

{{-- Load script only once --}}
@once
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script>
        function downloadTicketImage() {
            const ticket = document.querySelector('#captureArea');
            const btn = document.querySelector('#downloadBtn');
            const code = "{{ $code }}";

            btn.innerText = "GENERATING...";

            html2canvas(ticket, {
                scale: 3,
                backgroundColor: "#ffffff",
                logging: false,
                useCORS: true
            }).then(canvas => {
                const link = document.createElement('a');
                link.download = `CARE-Ticket-${code}.png`;
                link.href = canvas.toDataURL("image/png");
                link.click();

                btn.innerText = "SAVED!";
                setTimeout(() => {
                    btn.innerText = "SAVE TO DEVICE";
                }, 2000);
            });
        }
    </script>
@endonce
