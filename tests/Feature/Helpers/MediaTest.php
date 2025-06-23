<?php

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Helpers\Media;

beforeEach(function () {
    Storage::fake('public');
});

describe('Media Helper', function () {
    test('uploads a file and returns a Media instance with correct attributes', function () {
        $file = UploadedFile::fake()->create('church_bulletin.pdf', 250, 'application/pdf');
        $label = 'Church Bulletin';
        $directory = 'bulletins';

        $media = Media::upload($file, $directory, $label, 'public');

        expect($media)->toBeInstanceOf(Media::class)
            ->and($media->getFile())->toEqual($file)
            ->and($media->getPublicPath())->toContain("storage/uploads/{$directory}/")
            ->and($media->getPublicPath())->toEndWith('.pdf');

        Storage::disk('public')->assertExists(str_replace('storage/', '', $media->getPublicPath()));
    });

    test('uploads a file to default uploads directory if directory is not provided', function () {
        $file = UploadedFile::fake()->create('profile.jpg', 100);
        $media = Media::upload($file, '', 'Profile Image');

        expect($media->getPublicPath())->toContain('storage/uploads/')
            ->and($media->getPublicPath())->toEndWith('.jpg');

        Storage::disk('public')->assertExists(str_replace('storage/', '', $media->getPublicPath()));
    });
});
