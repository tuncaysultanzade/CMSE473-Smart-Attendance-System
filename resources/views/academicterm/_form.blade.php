@csrf

<div class="space-y-4">
    <div>
        <label for="term" class="block font-medium text-sm text-gray-700">Term</label>
        <select name="term" id="term" class="form-select mt-1 block w-full" required>
            <option value="">-- Select Term --</option>
            <option value="Fall" {{ old('term', $academicterm->term ?? '') == 'Fall' ? 'selected' : '' }}>Fall</option>
            <option value="Spring" {{ old('term', $academicterm->term ?? '') == 'Spring' ? 'selected' : '' }}>Spring</option>
            <option value="Summer" {{ old('term', $academicterm->term ?? '') == 'Summer' ? 'selected' : '' }}>Summer</option>
        </select>
    </div>

    <div>
        <label for="year" class="block font-medium text-sm text-gray-700">Academic Year</label>
        <input type="text" name="year" id="year" class="form-input mt-1 block w-full"
               value="{{ old('year', $academicterm->year ?? '') }}" placeholder="Ex: 2024/25" required>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label for="term_start" class="block font-medium text-sm text-gray-700">Term Start</label>
            <input type="date" name="term_start" id="term_start" class="form-input mt-1 block w-full"
                   value="{{ old('term_start', isset($academicterm) ? $academicterm->term_start->format('Y-m-d') : '') }}" required>
        </div>

        <div>
            <label for="term_end" class="block font-medium text-sm text-gray-700">Term End</label>
            <input type="date" name="term_end" id="term_end" class="form-input mt-1 block w-full"
                   value="{{ old('term_end', isset($academicterm) ? $academicterm->term_end->format('Y-m-d') : '') }}" required>
        </div>
    </div>

<div class="flex items-center">
    <input type="hidden" name="is_active" value="0">

    <input type="checkbox" name="is_active" id="is_active" value="1"
           {{ old('is_active', isset($academicterm) ? $academicterm->is_active : 0) ? 'checked' : '' }}
           class="form-checkbox h-4 w-4 text-indigo-600">

    <label for="is_active" class="ml-2 text-sm text-gray-700">Active Term</label>
</div>

    <div class="pt-4">
        <button type="submit" class="btn btn-primary bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded">
            {{ isset($academicterm) ? 'Update Term' : 'Create Term' }}
        </button>
        <a href="{{ route('academicterm.index') }}" class="btn btn-secondary text-gray-700 px-4 py-2 ml-2">Cancel</a>
    </div>
</div>
