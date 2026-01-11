@extends('layouts.app')

@section('title', 'Pesanan Saya')

@section('content')
    <div class="bg-[#FFFBF2] min-h-screen py-10 font-sans">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="flex items-center justify-between mb-8 animate-fade-in-down">
                <div>
                    <h1 class="text-3xl font-extrabold text-[#3E2723]">Pesanan Saya</h1>
                    <p class="text-gray-500 mt-1">Riwayat transaksi belanja.</p>
                </div>
                <a href="{{ route('products.catalog') }}"
                    class="hidden md:inline-flex items-center gap-2 text-[#D84315] font-bold hover:text-[#BF360C] transition-colors">
                    <i class="fas fa-shopping-bag"></i> Belanja Lagi
                </a>
            </div>

            {{-- List Pesanan --}}
            <div class="space-y-6">
                @forelse ($orders as $order)
                    <div
                        class="bg-white rounded-2xl shadow-sm border border-orange-100 overflow-hidden hover:shadow-md transition-shadow duration-300">

                        {{-- Header Card --}}
                        <div
                            class="bg-orange-50 px-6 py-4 border-b border-orange-100 flex flex-col md:flex-row justify-between md:items-center gap-4">
                            <div class="flex items-center gap-3">
                                <div class="bg-white p-2 rounded-lg text-[#D84315]">
                                    <i class="fas fa-receipt"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 uppercase tracking-wider">No. Pesanan</p>
                                    <p class="font-bold text-[#3E2723] font-mono">#{{ $order->order_number ?? $order->id }}
                                    </p>
                                </div>
                            </div>

                            {{-- Status Badge --}}
                            <div class="text-right">
                                @if ($order->status == 'completed')
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800 border border-green-200">
                                        <i class="fas fa-check-circle mr-1"></i> Selesai
                                    </span>
                                @elseif($order->status == 'pending')
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-800 border border-yellow-200">
                                        <i class="fas fa-clock mr-1"></i> Menunggu Verivikasi
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800 border border-blue-200">
                                        <i class="fas fa-spinner mr-1"></i> {{ ucfirst($order->status) }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{-- Body Card: Loop Item Produk Disini --}}
                        <div class="p-6 space-y-4">
                            @foreach ($order->items as $item)
                                {{-- Pastikan Order Model punya relasi ->items() --}}
                                <div
                                    class="flex items-center justify-between border-b border-dashed border-gray-100 pb-4 last:border-0 last:pb-0">
                                    <div class="flex items-center gap-4">
                                        {{-- Foto Produk --}}
                                        <div class="h-16 w-16 bg-gray-100 rounded-lg overflow-hidden">
                                            <img src="{{ asset($item->product->image ?? 'placeholder.jpg') }}"
                                                class="w-full h-full object-cover">
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-[#3E2723]">{{ $item->product->name }}</h4>
                                            <p class="text-xs text-gray-500">{{ $item->quantity }} x Rp
                                                {{ number_format($item->price) }}</p>
                                        </div>
                                    </div>

                                    {{-- Tombol Review (Hanya muncul jika Completed) --}}
                                    @if ($order->status == 'completed')
                                        <button
                                            onclick="openReviewModal('{{ $item->product->id }}', '{{ $item->product->name }}', '{{ $order->id }}')"
                                            class="text-sm font-bold text-[#D84315] hover:text-[#BF360C] hover:underline transition-colors">
                                            <i class="far fa-star mr-1"></i> Beri Ulasan
                                        </button>
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        {{-- Footer Total --}}
                        <div class="bg-gray-50 px-6 py-4 flex justify-between items-center">
                            <p class="text-sm text-gray-500">Total Belanja</p>
                            <p class="text-xl font-bold text-[#D84315]">Rp
                                {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                        </div>

                        {{-- Tombol Bayar jika Pending --}}
                        @if ($order->status == 'pending')
                            <div class="px-6 pb-6">
                                <a href="{{ route('payment.show', $order->id) }}"
                                    class="block w-full text-center bg-[#D84315] hover:bg-[#BF360C] text-white font-bold py-2 rounded-xl transition-all">Tunggu Konfirmasi Admin</a>
                            </div>
                        @endif

                    </div>
                @empty
                    <div class="text-center py-10">
                        <p class="text-gray-500">Belum ada pesanan.</p>
                    </div>
                @endforelse
            </div>

            {{-- === MODAL REVIEW POPUP === --}}
            <div id="reviewModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title"
                role="dialog" aria-modal="true">
                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"
                        onclick="closeReviewModal()"></div>
                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                    <div
                        class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                        <form action="{{ route('review.store') }}" method="POST">
                            @csrf
                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <div class="text-center">
                                    <div
                                        class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-orange-100 mb-4">
                                        <i class="fas fa-star text-[#D84315] text-xl"></i>
                                    </div>
                                    <h3 class="text-lg leading-6 font-bold text-[#3E2723]" id="modal-title">
                                        Beri Ulasan Produk
                                    </h3>
                                    <p class="text-sm text-gray-500 mt-2">
                                        Bagaimana kualitas <span id="modal_product_name"
                                            class="font-bold text-[#D84315]">Nama Produk</span>?
                                    </p>

                                    {{-- Hidden Inputs --}}
                                    <input type="hidden" name="product_id" id="modal_product_id">
                                    <input type="hidden" name="order_id" id="modal_order_id">

                                    {{-- Star Rating Input (CSS Only) --}}
                                    <div class="flex flex-row-reverse justify-center gap-2 mt-6 mb-4 rating-group">
                                        <input type="radio" name="rating" value="5" id="star5"
                                            class="hidden peer"><label for="star5"
                                            class="text-3xl text-gray-300 cursor-pointer peer-checked:text-yellow-400 hover:text-yellow-400 peer-hover:text-yellow-400 transition-colors"><i
                                                class="fas fa-star"></i></label>
                                        <input type="radio" name="rating" value="4" id="star4"
                                            class="hidden peer"><label for="star4"
                                            class="text-3xl text-gray-300 cursor-pointer peer-checked:text-yellow-400 hover:text-yellow-400 peer-hover:text-yellow-400 transition-colors"><i
                                                class="fas fa-star"></i></label>
                                        <input type="radio" name="rating" value="3" id="star3"
                                            class="hidden peer"><label for="star3"
                                            class="text-3xl text-gray-300 cursor-pointer peer-checked:text-yellow-400 hover:text-yellow-400 peer-hover:text-yellow-400 transition-colors"><i
                                                class="fas fa-star"></i></label>
                                        <input type="radio" name="rating" value="2" id="star2"
                                            class="hidden peer"><label for="star2"
                                            class="text-3xl text-gray-300 cursor-pointer peer-checked:text-yellow-400 hover:text-yellow-400 peer-hover:text-yellow-400 transition-colors"><i
                                                class="fas fa-star"></i></label>
                                        <input type="radio" name="rating" value="1" id="star1"
                                            class="hidden peer"><label for="star1"
                                            class="text-3xl text-gray-300 cursor-pointer peer-checked:text-yellow-400 hover:text-yellow-400 peer-hover:text-yellow-400 transition-colors"><i
                                                class="fas fa-star"></i></label>
                                    </div>

                                    {{-- Komentar --}}
                                    <textarea name="comment" rows="3"
                                        class="w-full rounded-xl border-gray-300 focus:ring-[#D84315] focus:border-[#D84315]"
                                        placeholder="Tulis pendapat disini..."></textarea>
                                </div>
                            </div>
                            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-2">
                                <button type="submit"
                                    class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-[#D84315] text-base font-medium text-white hover:bg-[#BF360C] focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                                    Kirim Ulasan
                                </button>
                                <button type="button" onclick="closeReviewModal()"
                                    class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                    Batal
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            @push('styles')
                <style>
                    /* Fix untuk Star Rating CSS trick */
                    .rating-group:hover label {
                        color: #FBBF24;
                        /* Yellow-400 */
                    }

                    .rating-group input:hover~label,
                    .rating-group input:checked~label {
                        color: #FBBF24;
                    }

                    .rating-group label:hover~label {
                        color: #D1D5DB;
                        /* Gray-300 back to gray */
                    }
                </style>
            @endpush

            @push('scripts')
                <script>
                    function openReviewModal(productId, productName, orderId) {
                        document.getElementById('modal_product_id').value = productId;
                        document.getElementById('modal_order_id').value = orderId;
                        document.getElementById('modal_product_name').innerText = productName;

                        // Reset Form
                        document.querySelectorAll('input[name="rating"]').forEach(el => el.checked = false);
                        document.querySelector('textarea[name="comment"]').value = '';

                        document.getElementById('reviewModal').classList.remove('hidden');
                    }

                    function closeReviewModal() {
                        document.getElementById('reviewModal').classList.add('hidden');
                    }
                </script>
            @endpush

        </div>
    </div>
@endsection
