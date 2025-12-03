<table class="table table-bordered align-middle">
    <thead class="table-responsive">
        <tr>
            <th style="width: 5%">No</th>
            <th style="width: 15%">Classroms names</th>
            <th style="width: 25%">List Teachers</th>
            <th>List students</th>
            <th style="width: 15%">NISN</th>
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
                                        <td rowspan="{{ $rowspan }}" class="bg-white align-top">
                                            @if($class->teachers->count() > 0)
                                                <ul class="list-group list-group-flush">
                                                    @foreach($class->teachers as $teacher)
                                                        <li class="list-group-item border-0 p-1">
                                                            <strong>{{ $teacher->name }}</strong><br>
                                                            <small class="text-muted">{{ $teacher->expertise }}</small>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                <span class="text-center text-muted">No Data Available</span>
                                            @endif
                                        </td>
                                    @endif
                                    <td>{{ $student->name }}</td>
                                    <td>{{ $student->nisn }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center">{{ $no++ }}</td>
                                    <td class="fw-bold">{{ $class->name }}</td>
                                    <td>
                                        @foreach($class->teachers as $t)
                                            <div>- {{ $t->name }}</div>
                                        @endforeach
                                    </td>
                                    <td colspan="2" class="text-center text-muted">No Data Available</td>
                                </tr>
                            @endforelse
        @endforeach
    </tbody>
</table>
