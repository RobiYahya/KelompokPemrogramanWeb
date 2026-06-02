<!-- Modal Download Report -->
<div id="modal-download-report" class="modal-overlay hidden">
    <div class="bg-white rounded-xl shadow-2xl w-[95%] max-w-5xl max-h-[90vh] flex flex-col overflow-hidden">

        <!-- Header -->
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 shrink-0">
            <h3 class="text-xl font-bold text-gray-800">Download Report</h3>
            <button onclick="closeModal('modal-download-report')" class="text-gray-400 hover:text-gray-700 hover:bg-gray-100 p-1.5 rounded-lg transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Filter Bar -->
        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200 shrink-0">
            <div class="flex flex-wrap items-end gap-3">
                <!-- Report Type -->
                <div class="flex flex-col min-w-[160px]">
                    <label class="text-xs font-semibold text-gray-500 mb-1.5 uppercase tracking-wider">Report Type</label>
                    <select id="rpt-type" class="px-3 py-2.5 border-2 border-gray-200 rounded-lg text-sm text-gray-700 bg-white focus:border-purple-500 focus:ring-2 focus:ring-purple-200 outline-none transition-all cursor-pointer">
                        <option value="barang_masuk">Incoming Items</option>
                        <option value="barang_keluar">Outgoing Items</option>
                        <option value="data_edit">Data Edit History</option>
                        <option value="data_delete">Data Delete History</option>
                    </select>
                </div>

                <!-- Start Date -->
                <div class="flex flex-col min-w-[140px]">
                    <label class="text-xs font-semibold text-gray-500 mb-1.5 uppercase tracking-wider">From Date</label>
                    <input type="date" id="rpt-start" class="px-3 py-2.5 border-2 border-gray-200 rounded-lg text-sm text-gray-700 bg-white focus:border-purple-500 focus:ring-2 focus:ring-purple-200 outline-none transition-all">
                </div>

                <!-- End Date -->
                <div class="flex flex-col min-w-[140px]">
                    <label class="text-xs font-semibold text-gray-500 mb-1.5 uppercase tracking-wider">To Date</label>
                    <input type="date" id="rpt-end" class="px-3 py-2.5 border-2 border-gray-200 rounded-lg text-sm text-gray-700 bg-white focus:border-purple-500 focus:ring-2 focus:ring-purple-200 outline-none transition-all">
                </div>

                <!-- Filter Button -->
                <button type="button" id="rpt-filter-btn" onclick="filterReport()"
                    class="px-5 py-2.5 bg-purple-600 hover:bg-purple-700 text-white text-sm font-semibold rounded-lg transition-all shadow-md hover:shadow-lg active:scale-95 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                    </svg>
                    Filter
                </button>
            </div>

            <!-- Search + Info Row -->
            <div class="flex flex-wrap items-center justify-between mt-3 gap-2" id="rpt-search-row" style="display: none;">
                <span class="text-sm text-gray-500" id="rpt-info"></span>
                <input type="text" id="rpt-search" placeholder="Search..." oninput="searchReport()"
                    class="px-3 py-2 border-2 border-gray-200 rounded-lg text-sm text-gray-700 bg-white focus:border-purple-500 focus:ring-2 focus:ring-purple-200 outline-none transition-all w-full sm:w-56">
            </div>
        </div>

        <!-- Table Preview -->
        <div class="flex-1 overflow-auto px-6 py-4" id="rpt-table-area">
            <!-- Empty State -->
            <div id="rpt-empty" class="flex flex-col items-center justify-center py-16 text-gray-400">
                <svg class="w-16 h-16 mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <p class="text-lg font-medium">Select date range and click Filter</p>
                <p class="text-sm mt-1">Data preview will appear here</p>
            </div>

            <!-- Loading State -->
            <div id="rpt-loading" class="flex flex-col items-center justify-center py-16" style="display: none;">
                <div class="w-10 h-10 border-4 border-purple-200 border-t-purple-600 rounded-full animate-spin mb-4"></div>
                <p class="text-sm text-gray-500">Loading data...</p>
            </div>

            <!-- Table -->
            <div id="rpt-table-wrap" style="display: none;">
                <table class="w-full text-sm" id="rpt-table">
                    <thead>
                        <tr id="rpt-thead" class="bg-gray-100 text-gray-600 text-xs uppercase tracking-wider"></tr>
                    </thead>
                    <tbody id="rpt-tbody" class="divide-y divide-gray-100"></tbody>
                </table>

                <!-- Pagination -->
                <div class="flex items-center justify-between mt-4 text-sm text-gray-500" id="rpt-pagination">
                    <span id="rpt-page-info"></span>
                    <div class="flex gap-1">
                        <button onclick="rptPagePrev()" id="rpt-prev-btn" class="px-3 py-1.5 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 disabled:opacity-40 disabled:cursor-not-allowed transition-all text-xs font-medium">← Prev</button>
                        <button onclick="rptPageNext()" id="rpt-next-btn" class="px-3 py-1.5 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 disabled:opacity-40 disabled:cursor-not-allowed transition-all text-xs font-medium">Next →</button>
                    </div>
                </div>
            </div>

            <!-- No Results -->
            <div id="rpt-no-results" style="display: none;" class="flex flex-col items-center justify-center py-16 text-gray-400">
                <svg class="w-14 h-14 mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                </svg>
                <p class="text-lg font-medium">No data found</p>
                <p class="text-sm mt-1">Try adjusting your date range</p>
            </div>
        </div>

        <!-- Footer: Download -->
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 shrink-0" id="rpt-footer" style="display: none;">
            <form action="{{ route('reports.download') }}" method="POST" class="flex flex-wrap items-center justify-between gap-3">
                @csrf
                <input type="hidden" name="start_date" id="rpt-dl-start">
                <input type="hidden" name="end_date" id="rpt-dl-end">
                <input type="hidden" name="report_type" id="rpt-dl-type">

                <span class="text-sm text-gray-500" id="rpt-dl-info"></span>

                <div class="flex gap-2">
                    <div class="flex items-center gap-2">
                        <label class="text-xs font-semibold text-gray-500 uppercase">Format:</label>
                        <select name="format" class="px-3 py-2 border-2 border-gray-200 rounded-lg text-sm bg-white focus:border-purple-500 outline-none cursor-pointer">
                            <option value="pdf">PDF</option>
                            <option value="excel">Excel (CSV)</option>
                        </select>
                    </div>
                    <button type="submit" class="px-5 py-2 bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white text-sm font-semibold rounded-lg transition-all shadow-md hover:shadow-lg active:scale-95 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Download
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>

<script>
(function() {
    // State
    let allRows = [];
    let filteredRows = [];
    let currentPage = 1;
    const perPage = 10;
    let currentType = '';
    let sortCol = -1;
    let sortAsc = true;

    // Default dates
    document.addEventListener('DOMContentLoaded', function() {
        const now = new Date();
        const first = new Date(now.getFullYear(), now.getMonth(), 1);
        document.getElementById('rpt-start').value = first.toISOString().split('T')[0];
        document.getElementById('rpt-end').value = now.toISOString().split('T')[0];
    });

    // Filter button click
    window.filterReport = function() {
        const type = document.getElementById('rpt-type').value;
        const start = document.getElementById('rpt-start').value;
        const end = document.getElementById('rpt-end').value;

        if (!start || !end) { alert('Please select both dates.'); return; }
        if (start > end) { alert('Start date must be before end date.'); return; }

        currentType = type;

        // Show loading
        document.getElementById('rpt-empty').style.display = 'none';
        document.getElementById('rpt-loading').style.display = 'flex';
        document.getElementById('rpt-table-wrap').style.display = 'none';
        document.getElementById('rpt-no-results').style.display = 'none';
        document.getElementById('rpt-footer').style.display = 'none';
        document.getElementById('rpt-search-row').style.display = 'none';

        const url = `{{ route('reports.preview') }}?report_type=${type}&start_date=${start}&end_date=${end}`;

        fetch(url, {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
        })
        .then(r => r.json())
        .then(data => {
            allRows = data.rows || [];
            filteredRows = [...allRows];
            currentPage = 1;
            sortCol = -1;

            document.getElementById('rpt-loading').style.display = 'none';

            if (allRows.length === 0) {
                document.getElementById('rpt-no-results').style.display = 'flex';
                return;
            }

            // Set download form values
            document.getElementById('rpt-dl-start').value = start;
            document.getElementById('rpt-dl-end').value = end;
            document.getElementById('rpt-dl-type').value = type;

            buildTable();

            document.getElementById('rpt-table-wrap').style.display = 'block';
            document.getElementById('rpt-footer').style.display = 'block';
            document.getElementById('rpt-search-row').style.display = 'flex';
            document.getElementById('rpt-search').value = '';
        })
        .catch(err => {
            document.getElementById('rpt-loading').style.display = 'none';
            document.getElementById('rpt-no-results').style.display = 'flex';
            console.error(err);
        });
    };

    // Get column definitions based on report type
    function getColumns() {
        if (currentType === 'barang_masuk' || currentType === 'barang_keluar') {
            return [
                { key: 'transaction_id', label: 'Transaction ID' },
                { key: 'item_id',        label: 'Item ID' },
                { key: 'item_name',      label: 'Item Name' },
                { key: 'quantity',       label: 'Qty' },
                { key: 'date',           label: 'Date' },
                { key: 'user',           label: 'User' },
                { key: 'description',    label: 'Description' },
            ];
        } else {
            return [
                { key: 'date',        label: 'Date' },
                { key: 'user',        label: 'User' },
                { key: 'action',      label: 'Action' },
                { key: 'item_name',   label: 'Item Name' },
                { key: 'category_id', label: 'Category ID' },
                { key: 'description', label: 'Description' },
            ];
        }
    }

    // Build table header + body
    function buildTable() {
        const cols = getColumns();
        const thead = document.getElementById('rpt-thead');
        thead.innerHTML = '';
        cols.forEach((col, idx) => {
            const th = document.createElement('th');
            th.className = 'px-4 py-3 text-left cursor-pointer select-none hover:text-purple-600 transition-colors';
            th.innerHTML = col.label + ' <span class="text-gray-300 ml-1">↕</span>';
            th.onclick = () => sortTable(idx);
            thead.appendChild(th);
        });

        renderRows();
        updateInfo();
    }

    // Render rows for current page
    function renderRows() {
        const cols = getColumns();
        const tbody = document.getElementById('rpt-tbody');
        tbody.innerHTML = '';

        const start = (currentPage - 1) * perPage;
        const pageRows = filteredRows.slice(start, start + perPage);

        if (pageRows.length === 0 && filteredRows.length === 0) {
            tbody.innerHTML = '<tr><td colspan="' + cols.length + '" class="px-4 py-8 text-center text-gray-400">No matching records</td></tr>';
        }

        pageRows.forEach(row => {
            const tr = document.createElement('tr');
            tr.className = 'hover:bg-purple-50/50 transition-colors';
            cols.forEach(col => {
                const td = document.createElement('td');
                td.className = 'px-4 py-3 text-gray-700';
                if (col.key === 'item_id' || col.key === 'category_id' || col.key === 'transaction_id') {
                    td.className += ' font-mono text-purple-600 font-medium';
                }
                if (col.key === 'quantity') {
                    td.className += ' font-semibold';
                }
                if (col.key === 'action') {
                    const val = row[col.key] || '';
                    const colors = { Add: 'bg-green-100 text-green-700', Edit: 'bg-yellow-100 text-yellow-700', Delete: 'bg-red-100 text-red-700', Incoming: 'bg-green-100 text-green-700', Outgoing: 'bg-blue-100 text-blue-700' };
                    const c = colors[val] || 'bg-gray-100 text-gray-600';
                    td.innerHTML = '<span class="px-2 py-0.5 rounded-full text-xs font-semibold ' + c + '">' + val + '</span>';
                } else {
                    td.textContent = row[col.key] ?? '-';
                }
                tr.appendChild(td);
            });
            tbody.appendChild(tr);
        });

        updatePagination();
    }

    // Update info text
    function updateInfo() {
        const total = filteredRows.length;
        const start = total === 0 ? 0 : (currentPage - 1) * perPage + 1;
        const end = Math.min(currentPage * perPage, total);
        document.getElementById('rpt-info').textContent = `Showing ${start}-${end} of ${total} records`;
        document.getElementById('rpt-dl-info').textContent = `${allRows.length} records ready to download`;
    }

    // Pagination
    function updatePagination() {
        const total = filteredRows.length;
        const totalPages = Math.ceil(total / perPage);
        const start = total === 0 ? 0 : (currentPage - 1) * perPage + 1;
        const end = Math.min(currentPage * perPage, total);

        document.getElementById('rpt-page-info').textContent = `Page ${currentPage} of ${totalPages || 1}`;
        document.getElementById('rpt-prev-btn').disabled = currentPage <= 1;
        document.getElementById('rpt-next-btn').disabled = currentPage >= totalPages;
        updateInfo();
    }

    window.rptPagePrev = function() { if (currentPage > 1) { currentPage--; renderRows(); } };
    window.rptPageNext = function() {
        const totalPages = Math.ceil(filteredRows.length / perPage);
        if (currentPage < totalPages) { currentPage++; renderRows(); }
    };

    // Search
    window.searchReport = function() {
        const q = document.getElementById('rpt-search').value.toLowerCase().trim();
        if (!q) {
            filteredRows = [...allRows];
        } else {
            filteredRows = allRows.filter(row => {
                return Object.values(row).some(v => String(v).toLowerCase().includes(q));
            });
        }
        currentPage = 1;
        renderRows();
    };

    // Sort
    function sortTable(colIdx) {
        const cols = getColumns();
        const key = cols[colIdx].key;

        if (sortCol === colIdx) {
            sortAsc = !sortAsc;
        } else {
            sortCol = colIdx;
            sortAsc = true;
        }

        filteredRows.sort((a, b) => {
            let va = a[key] ?? '';
            let vb = b[key] ?? '';
            if (typeof va === 'number' && typeof vb === 'number') return sortAsc ? va - vb : vb - va;
            va = String(va).toLowerCase();
            vb = String(vb).toLowerCase();
            if (va < vb) return sortAsc ? -1 : 1;
            if (va > vb) return sortAsc ? 1 : -1;
            return 0;
        });

        // Update header arrows
        const ths = document.getElementById('rpt-thead').children;
        for (let i = 0; i < ths.length; i++) {
            const arrow = i === colIdx ? (sortAsc ? ' ↑' : ' ↓') : ' ↕';
            const span = ths[i].querySelector('span');
            if (span) span.textContent = arrow;
        }

        currentPage = 1;
        renderRows();
    }
})();
</script>