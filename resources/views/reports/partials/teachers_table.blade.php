<table class="table table-bordered align-middle table-hover">
    <thead class="table-responsive">
        <tr>
            <th style="width: 5%">No</th>
            <th style="width: 20%">Classroms Names</th>
            <th style="width: 20%">NIP</th>
            <th>List Names</th>
            <th>Expertise</th>
        </tr>
    </thead>
    <tbody>
        @php $no = 1; @endphp
        @foreach($classrooms as $class)
            @php
                $totalGuru = $class->teachers->count();
                $rowspan = $totalGuru > 0 ? $totalGuru : 1;
            @endphp

            @forelse($class->teachers as $key => $teacher)
                <tr>
                    @if($key === 0)
                        <td rowspan="{{ $rowspan }}" class="text-center fw-bold bg-light">{{ $no++ }}</td>
                        <td rowspan="{{ $rowspan }}" class="fw-bold bg-light">{{ $class->name }}</td>
                    @endif
                    <td>{{ $teacher->nip }}</td>
                    <td>{{ $teacher->name }}</td>
                    <td>{{ $teacher->expertise }}</td>
                </tr>
            @empty
                <tr>
                    <td class="text-center">{{ $no++ }}</td>
                    <td class="fw-bold">{{ $class->name }}</td>
                    <td colspan="3" class="text-center text-muted">No Data Available</td>
                </tr>
            @endforelse
        @endforeach
    </tbody>
</table>
