<table class="table table-bordered align-middle table-hover">
    <thead class="table-responsive">
        <tr>
            <th style="width: 5%">No</th>
            <th style="width: 20%">Classrooms Names</th>
            <th style="width: 20%">NISN</th>
            <th>List students</th>
            <th>Gender</th>
        </tr>
    </thead>
    <tbody>
        @php $no = 1; @endphp
        @foreach($classrooms as $class)
                            @php
            $totalSiswa = $class->students->count();
            $rowspan = $totalSiswa > 0 ? $totalSiswa : 1;
                            @endphp

                            @forelse($class->students as $key => $student)
                                <tr>
                                    @if($key === 0)
                                        <td rowspan="{{ $rowspan }}" class="text-center fw-bold bg-light">{{ $no++ }}</td>
                                        <td rowspan="{{ $rowspan }}" class="fw-bold bg-light">{{ $class->name }}</td>
                                    @endif
                                    <td>{{ $student->nisn }}</td>
                                    <td>{{ $student->name }}</td>
                                    <td>{{ $student->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center fw-bold">{{ $no++ }}</td>
                                    <td class="fw-bold">{{ $class->name }}</td>
                                    <td colspan="3" class="text-center text-muted">No Data Available</td>
                                </tr>
                            @endforelse
        @endforeach
    </tbody>
</table>
