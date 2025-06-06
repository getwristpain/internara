<?php

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Helpers\Media;

beforeEach(function () {
    Storage::fake('public');
});

it('uploads a file and returns a Media instance with correct attributes', function () {
    $file = UploadedFile::fake()->create('church_bulletin.pdf', 250, 'application/pdf');
    $label = 'Church Bulletin';
    $directory = 'bulletins';

    $media = Media::upload($file, $directory, $label, 'public');

    expect($media)->toBeInstanceOf(Media::class)
        ->and($media->getFile())->toEqual($file)
        ->and($media->getPath())->toContain("storage/uploads/{$directory}/")
        ->and($media->getPath())->toEndWith('.pdf');

    Storage::disk('public')->assertExists(str_replace('storage/', '', $media->getPath()));
});

it('uploads a file to default uploads directory if directory is not provided', function () {
    $file = UploadedFile::fake()->create('profile.jpg', 100);
    $media = Media::upload($file, '', 'Profile Image');

    expect($media->getPath())->toContain('storage/uploads/')
        ->and($media->getPath())->toEndWith('.jpg');

    Storage::disk('public')->assertExists(str_replace('storage/', '', $media->getPath()));
});
