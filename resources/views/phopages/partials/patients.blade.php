<table id="disease-data-table" class="table table-striped table-bordered">
    <thead>
        <tr>
            <th class="text-nowrap">Disease Name</th>
            <th class="text-nowrap">ICD10 Code</th>
            <th class="text-nowrap male-column">0-9 M</th>
            <th class="text-nowrap female-column">0-9 F</th>
            <th class="text-nowrap male-column">10-19 M</th>
            <th class="text-nowrap female-column">10-19 F</th>
            <th class="text-nowrap male-column">20-59 M</th>
            <th class="text-nowrap female-column">20-59 F</th>
            <th class="text-nowrap male-column">60+ M</th>
            <th class="text-nowrap female-column">60+ F</th>
            <th class="text-nowrap male-column">Total M</th>
            <th class="text-nowrap female-column">Total F</th>
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