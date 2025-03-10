<table id="disease-data-table" class="table table-striped table-bordered">
    <thead>
        <tr>
            <th class="text-nowrap">Disease Name</th>
            <th class="text-nowrap">Disease Code</th>
            <th class="text-nowrap">0-9 Male</th>
            <th class="text-nowrap">0-9 Female</th>
            <th class="text-nowrap">10-19 Male</th>
            <th class="text-nowrap">10-19 Female</th>
            <th class="text-nowrap">20-59 Male</th>
            <th class="text-nowrap">20-59 Female</th>
            <th class="text-nowrap">60+ Male</th>
            <th class="text-nowrap">60+ Female</th>
            <th class="text-nowrap">Total M</th>
            <th class="text-nowrap">Total F</th>
            <th class="text-nowrap">Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($diseaseData as $data)
        <tr>
            <td>{{ $data['disease_name'] }}</td>
            <td>{{ $data['icd10_code'] }}</td>
            <td>{{ $data['counts']['age_0_9_male'] }}</td>
            <td>{{ $data['counts']['age_0_9_female'] }}</td>
            <td>{{ $data['counts']['age_10_19_male'] }}</td>
            <td>{{ $data['counts']['age_10_19_female'] }}</td>
            <td>{{ $data['counts']['age_20_59_male'] }}</td>
            <td>{{ $data['counts']['age_20_59_female'] }}</td>
            <td>{{ $data['counts']['age_60_above_male'] }}</td>
            <td>{{ $data['counts']['age_60_above_female'] }}</td>
            <td>{{ $data['counts']['age_all_male'] }}</td>
                <td>{{ $data['counts']['age_all_female'] }}</td>
                <td>{{ $data['counts']['age_total'] }}</td>
        </tr>
        @endforeach
    </tbody>
</table>