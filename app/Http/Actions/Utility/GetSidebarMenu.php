<?php

namespace App\Http\Actions\Utility;

class GetSidebarMenu
{
    /**
     * Handle the action to get sidebar menu.
     *
     * @return array
     */
    public function handle(): array
    {
        $menuItems = [
            'common' => [
                'admin' => [
                    [
                        "label" => 'Pengaturan',
                        "icon" => 'pi pi-cog',
                        "url" => '/settings/account'
                    ],
                    [
                        "label" => 'Keluar',
                        "icon" => 'pi pi-sign-out',
                        "url" => route('auth.logout')
                    ]
                ],
                'teacher' => [
                    [
                        "label" => 'Keluar',
                        "icon" => 'pi pi-sign-out',
                        "url" => route('auth.logout')
                    ]
                ],
                'student' => [
                    [
                        "label" => 'Keluar',
                        "icon" => 'pi pi-sign-out',
                        "url" => route('auth.logout')
                    ]
                ],
                'guest' => [
                    [
                        "label" => 'Login',
                        "icon" => 'pi pi-sign-in',
                        "url" => route('auth.login.index')
                    ]
                ],

            ],
            'guest' => [

            ],
            'admin' => [
                [
                    "label" => 'Beranda',
                    "icon" => 'pi pi-home',
                    "url" => route('app.dashboard')
                ],
                [
                    "label" => 'Siswa',
                    "icon" => 'pi pi-users',
                    "url" => route('app.students.index')
                ],
                [
                    "label" => 'Guru',
                    "icon" => 'pi pi-id-card',
                    "url" => route('app.teachers.index')
                ],
                [
                    "label" => 'Kelas',
                    "icon" => 'pi pi-home',
                    "url" => route('app.classes.index')
                ],
                [
                    "label" => 'Mata Pelajaran',
                    "icon" => 'pi pi-book',
                    "url" => route('app.subjects.index')
                ],
                [
                    "label" => 'Nilai',
                    "icon" => 'pi pi-chart-line',
                    "url" => route('app.exams.index')
                ],
                // [
                //     "label" => 'Jadwal Pelajaran',
                //     "icon" => 'pi pi-calendar',
                //     "url" => route('app.schedules.index')
                // ],
                // [
                //     "label" => 'Inventaris',
                //     "icon" => 'pi pi-box',
                //     "url" => route('app.inventory.index')
                // ],
                // [
                //     "label" => 'Laporan',
                //     "icon" => 'pi pi-file',
                //     "url" => route('app.reports.index')
                // ],
            ],
            'teacher' => [
                [
                    "label" => 'Beranda',
                    "icon" => 'pi pi-home',
                    "url" => route('app.dashboard')
                ],
                [
                    "label" => 'Beri Nilai',
                    "icon" => 'pi pi-pencil',
                    "url" => route('app.exams.index')
                ],
                [
                    "label" => 'Mata Pelajaran',
                    "icon" => 'pi pi-book',
                    "url" => route('app.subjects.index')
                ],
                // [
                //     "label" => 'Lihat Jadwal',
                //     "icon" => 'pi pi-calendar',
                //     "url" => route('app.schedules.index')
                // ],
                // [
                //     "label" => 'Inventaris Kelas',
                //     "icon" => 'pi pi-box',
                //     "url" => route('app.class_inventory.index')
                // ],
            ],
            'student' => [
                [
                    "label" => 'Beranda',
                    "icon" => 'pi pi-home',
                    "url" => route('app.dashboard')
                ],
                [
                    "label" => 'Mata Pelajaran',
                    "icon" => 'pi pi-book',
                    "url" => route('app.subjects.index')
                ],
                [
                    "label" => 'Lihat Nilai',
                    "icon" => 'pi pi-chart-line',
                    "url" => route('app.exams.index')
                ],
                // [
                //     "label" => 'Jadwal Pelajaran',
                //     "icon" => 'pi pi-calendar',
                //     "url" => route('app.schedules.index')
                // ],
                // [
                //     "label" => 'Inventaris Kelas',
                //     "icon" => 'pi pi-box',
                //     "url" => route('app.class_inventory.index')
                // ],
            ],
        ];

        $role = auth()->check() ? auth()->user()->role->name : 'guest';
        return [
            [
                "label" => 'Menu Utama',
                "items" => $menuItems[$role]
            ],
            [
                "label" => 'Lainnya',
                "items" => $menuItems['common'][$role]
            ],
        ];
    }
}
