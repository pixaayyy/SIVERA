<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\File;
use ZipArchive;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;

class BackupController extends Controller
{
    public function index()
    {
        return view('admin.backup');
    }

    public function backupDatabase()
    {
        try {
            set_time_limit(300); 

            $database = env('DB_DATABASE');
            $username = env('DB_USERNAME');
            $password = env('DB_PASSWORD');
            $host = env('DB_HOST');

            $fileName = 'backup_db_' . $database . '_' . date('Y-m-d_H-i-s') . '.sql';
            $filePath = storage_path('app/public/' . $fileName);

            $dumpPath = "C:\\laragon\\bin\\mysql\\mysql-8.0.30-winx64\\bin\\mysqldump";
            $command = "\"{$dumpPath}\" --user={$username} --password={$password} --host={$host} {$database} > \"{$filePath}\"";
            
            exec($command, $output, $returnVar);

            if ($returnVar !== 0) {
                return back()->with('error', 'Gagal membackup database. Pastikan mysqldump dikenali oleh server.');
            }

            return Response::download($filePath)->deleteFileAfterSend(true);

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function backupSourceCode()
    {
        try {
            set_time_limit(600);
            ini_set('memory_limit', '512M');

            $zipFileName = 'backup_source_' . date('Y-m-d_H-i-s') . '.zip';
            $zipFilePath = storage_path('app/public/' . $zipFileName);

            $zip = new ZipArchive;

            if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
                
                $path = base_path(); 
                
                $files = new RecursiveIteratorIterator(
                    new RecursiveDirectoryIterator($path),
                    RecursiveIteratorIterator::LEAVES_ONLY
                );

                foreach ($files as $name => $file) {
                    if (!$file->isDir()) {
                        $filePath = $file->getRealPath();
                        $relativePath = substr($filePath, strlen($path) + 1);

                        if (!str_contains($relativePath, 'vendor' . DIRECTORY_SEPARATOR) && 
                            !str_contains($relativePath, 'node_modules' . DIRECTORY_SEPARATOR) &&
                            !str_contains($relativePath, '.git' . DIRECTORY_SEPARATOR)) {
                            
                            $zip->addFile($filePath, $relativePath);
                        }
                    }
                }
                $zip->close();
            } else {
                return back()->with('error', 'Gagal membuat file Zip.');
            }

            return Response::download($zipFilePath)->deleteFileAfterSend(true);

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}