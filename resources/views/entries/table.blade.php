@extends('layouts.app')
@section('title', 'All Entries')
@section('page-title', 'Entries Datatable')

@section('content')

<!-- Filters -->
<div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800
            rounded-xl p-5 mb-5">
  <form method="GET" action="{{ route('entries.table') }}">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">

      <!-- Register Type -->
      <div class="lg:col-span-2">
        <label class="block text-xs text-gray-500 dark:text-gray-500 mb-1.5">Register Type</label>
        <select name="register_type"
                class="w-full bg-gray-50 dark:bg-gray-950 border border-gray-200
                       dark:border-gray-800 rounded-lg px-3 py-2.5 text-sm
                       text-gray-900 dark:text-gray-200 focus:outline-none
                       focus:ring-1 focus:ring-indigo-500">
          <option value="">All Registers</option>
          @foreach($registers as $key => $reg)
            <option value="{{ $key }}" {{ $registerType === $key ? 'selected' : '' }}>
              {{ $reg['name'] }}
            </option>
          @endforeach
        </select>
      </div>

      <!-- Status -->
      <div>
        <label class="block text-xs text-gray-500 dark:text-gray-500 mb-1.5">Status</label>
        <select name="status"
                class="w-full bg-gray-50 dark:bg-gray-800 border border-gray-200
                       dark:border-gray-800 rounded-lg px-3 py-2.5 text-sm
                       text-gray-900 dark:text-gray-200 focus:outline-none
                       focus:ring-1 focus:ring-indigo-500">
          <option value="">All Status</option>
          <option value="pending"        {{ request('status') === 'pending'        ? 'selected' : '' }}>Pending</option>
          <option value="approved"       {{ request('status') === 'approved'       ? 'selected' : '' }}>Approved</option>
          <option value="rejected"       {{ request('status') === 'rejected'       ? 'selected' : '' }}>Rejected</option>
          <option value="edit_requested" {{ request('status') === 'edit_requested' ? 'selected' : '' }}>Edit Requested</option>
        </select>
      </div>

      <!-- From Date -->
      <div>
        <label class="block text-xs text-gray-500 dark:text-gray-500 mb-1.5">From Date</label>
        <input type="date" name="from_date" value="{{ $fromDate }}"
               class="w-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-800
            rounded-lg px-3 py-2.5
                            text-sm text-gray-500 focus:outline-none focus:ring-1
                            focus:ring-indigo-500 focus:border-indigo-500"/>
      </div>

      <!-- To Date -->
      <div>
        <label class="block text-xs text-gray-500 dark:text-gray-500 mb-1.5">To Date</label>
        <input type="date" name="to_date" value="{{ $toDate }}"
               class="w-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-800
            rounded-lg px-3 py-2.5
                            text-sm text-gray-500 focus:outline-none focus:ring-1
                            focus:ring-indigo-500 focus:border-indigo-500"/>
      </div>

    </div>

    <div class="flex items-center gap-2 mt-3">
      <button type="submit"
              class="bg-indigo-600 hover:bg-indigo-500 text-white text-xs
                     font-medium px-4 py-2 rounded-lg transition-colors">
        Apply Filters
      </button>
      <a href="{{ route('entries.table') }}"
         class="text-xs transition-colors text-gray-500 hover:text-gray-700
                dark:hover:text-gray-300">
        Clear
      </a>
      <span class="text-xs text-gray-400 dark:text-gray-600 ml-auto">
        {{ $entries->total() }} {{ Str::plural('entry', $entries->total()) }} found
      </span>
    </div>
  </form>
</div>

<!-- Table -->
<div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800
            rounded-xl overflow-hidden">

  <!-- Table Header with PDF button -->
  <div class="flex items-center justify-between px-5 py-3
              border-b border-gray-200 dark:border-gray-800">
    <p class="text-sm font-medium text-gray-700 dark:text-gray-300">
      @if($registerType && isset($registers[$registerType]))
        {{ $registers[$registerType]['name'] }}
      @else
        All Entries
      @endif
    </p>
    @if($entries->count() > 0)
    <button onclick="downloadPDF()"
            class="flex items-center gap-1.5 bg-rose-600 hover:bg-rose-500
                   text-white text-xs font-medium px-3 py-2 rounded-lg transition-colors">
      <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586
                 a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
      </svg>
      Download PDF
    </button>
    @endif
  </div>

  @if($registerType && count($fields) > 0)
  <div class="overflow-x-auto">
    <table class="w-full text-xs" id="entries-table">
      @php
        $remarksField  = collect($fields)->firstWhere('is_remarks', true);
        $regularFields = collect($fields)->filter(fn($f) => empty($f['is_remarks']))->values();
        $reviewFields  = config("registers.{$registerType}.review_fields", []);
      @endphp

      <thead>
        <tr class="border-b border-gray-200 dark:border-gray-800
                  bg-gray-50 dark:bg-gray-800/40">
          {{-- Regular fields (no remarks) --}}
          @foreach($regularFields as $field)
            <th class="text-left px-4 py-3 font-medium whitespace-nowrap
                      text-gray-500 dark:text-gray-500">
              {{ $field['label'] }}
            </th>
          @endforeach

          {{-- Review fields --}}
          @if(auth()->user()->hasAnyRole(['admin','manager']))
            @foreach($reviewFields as $rf)
              <th class="text-left px-4 py-3 font-medium whitespace-nowrap
                        text-emerald-600 dark:text-emerald-700">
                {{ $rf['label'] }}
              </th>
            @endforeach
          @endif

          {{-- Remarks always last --}}
          @if($remarksField)
            <th class="text-left px-4 py-3 font-medium whitespace-nowrap
                      text-gray-500 dark:text-gray-500">
              {{ $remarksField['label'] }}
            </th>
          @endif
        </tr>
      </thead>

      <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
        @forelse($entries as $entry)
        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/30 transition-colors">

          {{-- Regular fields --}}
          @foreach($regularFields as $field)
            <td class="px-4 py-3 whitespace-nowrap text-gray-700 dark:text-gray-300">
              {{ $entry->field($field['name']) }}
            </td>
          @endforeach

          {{-- Review fields --}}
          @if(auth()->user()->hasAnyRole(['admin','manager']))
            @foreach($reviewFields as $rf)
              <td class="px-4 py-3 whitespace-nowrap text-emerald-600 dark:text-emerald-400">
                {{ $entry->reviewField($rf['name']) }}
              </td>
            @endforeach
          @endif

          {{-- Remarks always last --}}
          @if($remarksField)
            <td class="px-4 py-3 whitespace-nowrap text-gray-700 dark:text-gray-300">
              {{ $entry->field('remarks') }}
            </td>
          @endif

        </tr>
        @empty
        <tr>
          <td colspan="20"
              class="px-5 py-10 text-center text-gray-400 dark:text-gray-600">
            No entries found.
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  @else
    <!-- <div class="px-5 py-3 border-t border-gray-200 dark:border-gray-800">
    <p class="text-xs text-gray-400 dark:text-gray-600">
      💡 Select a register type above first
    </p>
  </div> -->
  <!-- <div class="overflow-x-auto">
    <table class="w-full text-xs" id="entries-table">
      <thead>
        <tr class="border-b border-gray-200 dark:border-gray-800
                   bg-gray-50 dark:bg-gray-800/40">
          <th class="text-left px-4 py-3 font-medium text-gray-500 dark:text-gray-500">Register</th>
          <th class="text-left px-4 py-3 font-medium text-gray-500 dark:text-gray-500">Submitted By</th>
          <th class="text-left px-4 py-3 font-medium text-gray-500 dark:text-gray-500">Status</th>
          <th class="text-left px-4 py-3 font-medium text-gray-500 dark:text-gray-500">Date</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
        @forelse($entries as $entry)
        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/30 transition-colors">
          <td class="px-4 py-3 text-gray-700 dark:text-gray-300">{{ $entry->registerName() }}</td>
          <td class="px-4 py-3 text-gray-700 dark:text-gray-300">{{ $entry->user->name }}</td>
          <td class="px-4 py-3">
            @php
              $badge = [
                'pending'        => 'bg-amber-100 dark:bg-amber-900/50 text-amber-700 dark:text-amber-400 border-amber-300 dark:border-amber-800',
                'approved'       => 'bg-emerald-100 dark:bg-emerald-900/50 text-emerald-700 dark:text-emerald-400 border-emerald-300 dark:border-emerald-800',
                'rejected'       => 'bg-rose-100 dark:bg-rose-900/50 text-rose-700 dark:text-rose-400 border-rose-300 dark:border-rose-800',
                'edit_requested' => 'bg-orange-100 dark:bg-orange-900/50 text-orange-700 dark:text-orange-400 border-orange-300 dark:border-orange-800',
              ][$entry->status] ?? '';
            @endphp
            <span class="inline-flex px-2 py-0.5 rounded border text-xs {{ $badge }}">
              {{ ucfirst(str_replace('_', ' ', $entry->status)) }}
            </span>
          </td>
          <td class="px-4 py-3 text-gray-500 dark:text-gray-500">
            {{ $entry->created_at->format('d M Y') }}
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="4"
              class="px-5 py-10 text-center text-gray-400 dark:text-gray-600">
            No entries found.
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div> -->

  @if(!$registerType)
  <div class="px-5 py-3 border-t border-gray-200 dark:border-gray-800">
    <p class="text-xs text-gray-400 dark:text-gray-600">
      💡 Select a register type above to see detailed columns
    </p>
  </div>
  @endif

  @endif

  @if($entries->hasPages())
  <div class="px-5 py-3 border-t border-gray-200 dark:border-gray-800">
    {{ $entries->links() }}
  </div>
  @endif

</div>

<!-- Hidden PDF template -->
<div id="pdf-content" style="display:none;">
  <div id="pdf-header" style="text-align:center; margin-bottom:16px; font-family: Arial, sans-serif;">
    @if(config('brand.logo_image'))
      <img src="{{ asset(config('brand.logo_image')) }}"
           style="height:50px; margin-bottom:6px;"/>
    @endif
    <div style="font-size:16px; font-weight:bold; text-transform:uppercase; letter-spacing:1px;">
      {{ config('brand.name') }}
    </div>
    <div style="font-size:11px; color:#555; margin-top:2px;">
      {{ config('brand.location') }}
    </div>
    <div style="font-size:11px; font-weight:600; margin-top:6px; text-align:left;">
      Register Name:
      @if($registerType && isset($registers[$registerType]))
        {{ $registers[$registerType]['name'] }}
      @else
        All Entries
      @endif
    </div>
    @if($fromDate || $toDate)
    <div style="font-size:10px; color:#777; text-align:left; margin-top:2px;">
      Period: {{ $fromDate ?: '—' }} to {{ $toDate ?: '—' }}
    </div>
    @endif
    <hr style="margin:10px 0; border-color:#ccc;"/>
  </div>
</div>

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.8.2/jspdf.plugin.autotable.min.js"></script>

<script>
async function downloadPDF() {
  const { jsPDF } = window.jspdf;
  const doc = new jsPDF({ orientation: 'landscape', unit: 'mm', format: 'a4' });

  const appName      = "{{ config('brand.name') }}";
  const location     = "{{ config('brand.location') }}";
  const logoImage    = "{{ config('brand.logo_image') ? asset(config('brand.logo_image')) : '' }}";
  const registerName = @if($registerType && isset($registers[$registerType]))"{{ $registers[$registerType]['name'] }}"@else"All Entries"@endif;
  const hasManagerAccess = @if(auth()->user()->hasAnyRole(['admin','manager'])) true @else false @endif;

  const allFieldNames = @if($registerType && isset($registers[$registerType]))
    {!! json_encode(array_column(config("registers.{$registerType}.fields", []), 'name')) !!}
  @else [] @endif;

  const allFieldLabels = @if($registerType && isset($registers[$registerType]))
    {!! json_encode(array_column(config("registers.{$registerType}.fields", []), 'label')) !!}
  @else [] @endif;

  const allFieldIsRemarks = @if($registerType && isset($registers[$registerType]))
    {!! json_encode(array_map(fn($f) => !empty($f['is_remarks']), config("registers.{$registerType}.fields", []))) !!}
  @else [] @endif;

  const reviewFieldNames = @if($registerType && isset($registers[$registerType]))
    {!! json_encode(array_column(config("registers.{$registerType}.review_fields", []), 'name')) !!}
  @else [] @endif;

  const reviewFieldLabels = @if($registerType && isset($registers[$registerType]))
    {!! json_encode(array_column(config("registers.{$registerType}.review_fields", []), 'label')) !!}
  @else [] @endif;

  // Entries data from server with signatures
  const entriesData = @if($registerType && isset($registers[$registerType]))
    {!! json_encode($entries->map(function($e) {
        return [
            'form_data'      => $e->form_data,
            'review_data'    => $e->review_data,
            'reviewed_at'    => $e->reviewed_at?->format('d M Y'),
            'signature_url'  => $e->user?->hasSignature() ? $e->user->signatureUrl() : null,
            'user_name'      => $e->user?->name,
            'reviewer_name'  => $e->reviewer?->name,
        ];
    })) !!}
  @else [] @endif;

  const pageW = doc.internal.pageSize.getWidth();
  const pageH = doc.internal.pageSize.getHeight();
  let y = 10;

  // ── Logo ──────────────────────────────────────────────────────────────
  if (logoImage) {
    try { doc.addImage(logoImage, 'PNG', 10, y, 20, 20); } catch(e) {}
  }

  // ── Company name ──────────────────────────────────────────────────────
  doc.setFont('helvetica', 'bold');
  doc.setFontSize(14);
  doc.setTextColor(30);
  doc.text(appName.toUpperCase(), pageW / 2, y + 8, { align: 'center' });

  doc.setFont('helvetica', 'normal');
  doc.setFontSize(9);
  doc.setTextColor(80);
  doc.text(location, pageW / 2, y + 15, { align: 'center' });

  y += 24;
  doc.setFont('helvetica', 'bold');
  doc.setFontSize(9);
  doc.setTextColor(30);
  doc.text('Register Name: ' + registerName, 10, y);

  @if($fromDate || $toDate)
  y += 5;
  doc.setFont('helvetica', 'normal');
  doc.setFontSize(8);
  doc.setTextColor(100);
  doc.text('Period: {{ $fromDate ?: "—" }} to {{ $toDate ?: "—" }}', 10, y);
  @endif

  y += 4;
  doc.setDrawColor(180);
  doc.line(10, y, pageW - 10, y);
  y += 4;

  if (allFieldNames.length === 0 || entriesData.length === 0) {
    doc.setFont('helvetica', 'normal');
    doc.setFontSize(10);
    doc.setTextColor(150);
    doc.text('No data to export.', pageW / 2, y + 20, { align: 'center' });
  } else {

    // ── Separate remarks ───────────────────────────────────────────────
    const remarksIndex       = allFieldNames.findIndex((_, i) => allFieldIsRemarks[i]);
    const regularFieldNames  = allFieldNames.filter((_, i) => !allFieldIsRemarks[i]);
    const regularFieldLabels = allFieldLabels.filter((_, i) => !allFieldIsRemarks[i]);

    // ── Find done_by and date field indices ────────────────────────────
    const doneByIndex   = regularFieldNames.indexOf('done_by');
    const dateFieldName = regularFieldNames.includes('date') ? 'date' : null;

    // ── Build headers ──────────────────────────────────────────────────
    const finalHeaders = [];
    const colTypes     = []; // track column type for row building

    regularFieldNames.forEach((name, i) => {
      finalHeaders.push(regularFieldLabels[i]);
      colTypes.push({ type: 'field', name });
    });

    // Done By Signature column (blank — user will physically sign)
    if (doneByIndex !== -1) {
      finalHeaders.splice(doneByIndex + 1, 0, 'Done By\nSignature');
      colTypes.splice(doneByIndex + 1, 0, { type: 'signature' });
    }

    // Done By Date column
    finalHeaders.push('Done By\nDate');
    colTypes.push({ type: 'done_date' });

    // Review fields (Checked By etc)
    if (hasManagerAccess) {
      reviewFieldLabels.forEach((label, i) => {
        finalHeaders.push(label);
        colTypes.push({ type: 'review', name: reviewFieldNames[i] });
      });

      // Checked By Date
      finalHeaders.push('Checked By\nDate');
      colTypes.push({ type: 'checked_date' });
    }

    // Remarks last
    if (remarksIndex !== -1) {
      finalHeaders.push('Remarks');
      colTypes.push({ type: 'remarks' });
    }

    // ── Build rows ─────────────────────────────────────────────────────
    const sigColIndex = colTypes.findIndex(c => c.type === 'signature');

    // We'll build text rows first, then add images after autoTable
    const finalRows = entriesData.map(entry => {
      return colTypes.map(col => {
        if (col.type === 'field')        return entry.form_data?.[col.name] ?? '—';
        if (col.type === 'signature')    return ''; // blank — image added after
        if (col.type === 'done_date')    return entry.form_data?.['date'] ?? entry.form_data?.['kept_date'] ?? '—';
        if (col.type === 'review')       return entry.review_data?.[col.name] ?? '—';
        if (col.type === 'checked_date') return entry.reviewed_at ?? '—';
        if (col.type === 'remarks')      return entry.form_data?.['remarks'] ?? '—';
        return '—';
      });
    });

    // ── Column styles ──────────────────────────────────────────────────
    const columnStyles = {};
    colTypes.forEach((col, i) => {
      if (col.type === 'signature') {
        columnStyles[i] = { cellWidth: 30, minCellHeight: 18 };
      }
      if (col.type === 'remarks') {
        columnStyles[i] = { cellWidth: 30 };
      }
    });

    // ── AutoTable ──────────────────────────────────────────────────────
    doc.autoTable({
      head: [finalHeaders],
      body: finalRows,
      startY: y,
      styles: {
        fontSize: 7,
        cellPadding: 3,
        lineColor: [200, 200, 200],
        lineWidth: 0.3,
        textColor: [30, 30, 30],
        overflow: 'linebreak',
      },
      headStyles: {
        fillColor: [79, 70, 229],
        textColor: [255, 255, 255],
        fontStyle: 'bold',
        fontSize: 7.5,
        minCellHeight: 10,
      },
      alternateRowStyles: {
        fillColor: [248, 250, 252],
      },
      columnStyles,
      margin: { left: 10, right: 10 },
    });

    // ── Inject signature images into signature column ───────────────────
    if (sigColIndex !== -1) {
      const tableData = doc.lastAutoTable;

      for (let rowIdx = 0; rowIdx < entriesData.length; rowIdx++) {
        const sigUrl = entriesData[rowIdx].signature_url;
        if (!sigUrl) continue;

        try {
          // Convert to base64
          const imgData = await toBase64(sigUrl);
          if (!imgData) continue;

          // Get cell position from autoTable
          const cell = tableData.body[rowIdx]?.cells[sigColIndex];
          if (!cell) continue;

          const cellX = cell.x + 1;
          const cellY = cell.y + 1;
          const cellW = cell.width - 2;
          const cellH = cell.height - 2;

          doc.addImage(imgData, 'PNG', cellX, cellY, cellW, cellH);
        } catch(e) {
          console.warn('Could not load signature for row', rowIdx);
        }
      }
    }
  }

  // ── Save ──────────────────────────────────────────────────────────────
  const now = new Date();
  const dateTime =
    now.getFullYear() + '-' +
    String(now.getMonth() + 1).padStart(2, '0') + '-' +
    String(now.getDate()).padStart(2, '0') + '_' +
    String(now.getHours()).padStart(2, '0') + '-' +
    String(now.getMinutes()).padStart(2, '0');

  doc.save(registerName.replace(/\s+/g, '_') + '_' + dateTime + '.pdf');
}

// Helper: convert image URL to base64
async function toBase64(url) {
  try {
    const response = await fetch(url);
    const blob     = await response.blob();
    return await new Promise((resolve, reject) => {
      const reader = new FileReader();
      reader.onloadend = () => resolve(reader.result);
      reader.onerror  = reject;
      reader.readAsDataURL(blob);
    });
  } catch(e) {
    return null;
  }
}
</script>
@endpush
@endsection