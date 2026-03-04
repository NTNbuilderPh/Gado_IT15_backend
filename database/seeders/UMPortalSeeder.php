<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Message;
use App\Models\Payment;
use App\Models\Student;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UMPortalSeeder extends Seeder
{
    /**
     * Seed the University of Mindanao Academic Portal.
     *
     * Run:  php artisan db:seed --class=UMPortalSeeder
     */
    public function run(): void
    {
        $this->command->info('🏫 Seeding University of Mindanao Portal Data...');

        // ──────────────────────────────────────────────
        // 1. COURSES  (IT15 – BSIT Curriculum)
        // ──────────────────────────────────────────────
        $courses = [
            [
                'course_code'   => 'IT15',
                'course_name'   => 'Web Systems and Technologies',
                'description'   => 'Fundamentals of web development including HTML, CSS, JavaScript, PHP, and Laravel framework.',
                'units'         => 3,
                'schedule'      => 'MWF 9:00-10:00 AM',
                'instructor'    => 'Prof. Maria Santos',
                'room'          => 'IT Lab 3',
                'capacity'      => 40,
                'semester'      => '1st Semester',
                'academic_year' => '2024-2025',
            ],
            [
                'course_code'   => 'IT14',
                'course_name'   => 'Database Management Systems',
                'description'   => 'Relational database design, SQL, normalisation, and database administration.',
                'units'         => 3,
                'schedule'      => 'TTh 10:30-12:00 PM',
                'instructor'    => 'Prof. Juan Dela Cruz',
                'room'          => 'IT Lab 1',
                'capacity'      => 35,
                'semester'      => '1st Semester',
                'academic_year' => '2024-2025',
            ],
            [
                'course_code'   => 'IT16',
                'course_name'   => 'Information Assurance and Security',
                'description'   => 'Security principles, cryptography, network security, and ethical hacking.',
                'units'         => 3,
                'schedule'      => 'MWF 1:00-2:00 PM',
                'instructor'    => 'Prof. Ana Reyes',
                'room'          => 'Room 201',
                'capacity'      => 40,
                'semester'      => '1st Semester',
                'academic_year' => '2024-2025',
            ],
            [
                'course_code'   => 'IT13',
                'course_name'   => 'Object-Oriented Programming',
                'description'   => 'Advanced OOP concepts using Java/C# including design patterns and SOLID principles.',
                'units'         => 3,
                'schedule'      => 'TTh 1:00-2:30 PM',
                'instructor'    => 'Prof. Carlos Mendoza',
                'room'          => 'IT Lab 2',
                'capacity'      => 35,
                'semester'      => '1st Semester',
                'academic_year' => '2024-2025',
            ],
            [
                'course_code'   => 'GE05',
                'course_name'   => 'Purposive Communication',
                'description'   => 'Communication for academic and professional purposes.',
                'units'         => 3,
                'schedule'      => 'MWF 10:00-11:00 AM',
                'instructor'    => 'Prof. Lisa Tan',
                'room'          => 'Room 305',
                'capacity'      => 45,
                'semester'      => '1st Semester',
                'academic_year' => '2024-2025',
            ],
            [
                'course_code'   => 'IT17',
                'course_name'   => 'Networking Fundamentals',
                'description'   => 'TCP/IP, network topologies, routing, switching, and network administration.',
                'units'         => 3,
                'schedule'      => 'TTh 3:00-4:30 PM',
                'instructor'    => 'Prof. Roberto Garcia',
                'room'          => 'NetLab 1',
                'capacity'      => 30,
                'semester'      => '1st Semester',
                'academic_year' => '2024-2025',
            ],
            [
                'course_code'   => 'MATH02',
                'course_name'   => 'Discrete Mathematics',
                'description'   => 'Logic, sets, relations, functions, graph theory, and combinatorics.',
                'units'         => 3,
                'schedule'      => 'MWF 2:00-3:00 PM',
                'instructor'    => 'Prof. Elena Cruz',
                'room'          => 'Room 102',
                'capacity'      => 40,
                'semester'      => '1st Semester',
                'academic_year' => '2024-2025',
            ],
            [
                'course_code'   => 'PE03',
                'course_name'   => 'Physical Education 3',
                'description'   => 'Team sports and physical fitness.',
                'units'         => 2,
                'schedule'      => 'Sat 8:00-10:00 AM',
                'instructor'    => 'Coach Miguel Torres',
                'room'          => 'Gymnasium',
                'capacity'      => 50,
                'semester'      => '1st Semester',
                'academic_year' => '2024-2025',
            ],
        ];

        foreach ($courses as $courseData) {
            Course::create($courseData);
        }

        $this->command->info('  ✅ ' . count($courses) . ' courses created.');

        // ──────────────────────────────────────────────
        // 2. DEMO STUDENTS
        // ──────────────────────────────────────────────
        $students = [
            [
                'student_number'      => '22-00001',
                'first_name'          => 'Gado',
                'last_name'           => 'Developer',
                'email'               => 'gado@um.edu.ph',
                'password'            => 'password123',
                'phone'               => '09171234567',
                'gender'              => 'Male',
                'program'             => 'BSIT',
                'year_level'          => '3rd Year',
                'date_of_birth'       => '2002-05-15',
                'address'             => 'Tagum City, Davao del Norte',
                'tuition_balance'     => 15000.00,
                'scholarship_balance' => 5000.00,
            ],
            [
                'student_number'      => '22-00002',
                'first_name'          => 'Maria',
                'last_name'           => 'Santos',
                'email'               => 'maria.santos@um.edu.ph',
                'password'            => 'password123',
                'phone'               => '09181234567',
                'gender'              => 'Female',
                'program'             => 'BSIT',
                'year_level'          => '3rd Year',
                'date_of_birth'       => '2003-01-20',
                'address'             => 'Panabo City, Davao del Norte',
                'tuition_balance'     => 12000.00,
                'scholarship_balance' => 3000.00,
            ],
            [
                'student_number'      => '23-00010',
                'first_name'          => 'Juan',
                'last_name'           => 'Dela Cruz',
                'email'               => 'juan.delacruz@um.edu.ph',
                'password'            => 'password123',
                'phone'               => '09191234567',
                'gender'              => 'Male',
                'program'             => 'BSCS',
                'year_level'          => '2nd Year',
                'date_of_birth'       => '2004-08-10',
                'address'             => 'Tagum City, Davao del Norte',
                'tuition_balance'     => 18000.00,
                'scholarship_balance' => 0.00,
            ],
        ];

        $createdStudents = [];
        foreach ($students as $studentData) {
            $createdStudents[] = Student::create($studentData);
        }

        $this->command->info('  ✅ ' . count($students) . ' demo students created.');

        // ──────────────────────────────────────────────
        // 3. DEMO ENROLLMENTS (course_student pivot)
        // ──────────────────────────────────────────────
        $gado  = $createdStudents[0];
        $maria = $createdStudents[1];
        $juan  = $createdStudents[2];

        // Gado enrolls in IT15, IT14, IT16
        $gadoCourses = Course::whereIn('course_code', ['IT15', 'IT14', 'IT16'])->get();
        foreach ($gadoCourses as $course) {
            $gado->courses()->attach($course->id, [
                'enrolled_at'           => now(),
                'grade'                 => $course->course_code === 'IT15' ? 1.50 : null,
                'attendance_percentage' => $course->course_code === 'IT15' ? 95.5 : 100,
                'status'                => 'enrolled',
            ]);
            $course->increment('students_count');
        }

        // Maria enrolls in IT15, GE05, MATH02
        $mariaCourses = Course::whereIn('course_code', ['IT15', 'GE05', 'MATH02'])->get();
        foreach ($mariaCourses as $course) {
            $maria->courses()->attach($course->id, [
                'enrolled_at'           => now(),
                'grade'                 => null,
                'attendance_percentage' => 92.0,
                'status'                => 'enrolled',
            ]);
            $course->increment('students_count');
        }

        // Juan enrolls in IT13, IT14
        $juanCourses = Course::whereIn('course_code', ['IT13', 'IT14'])->get();
        foreach ($juanCourses as $course) {
            $juan->courses()->attach($course->id, [
                'enrolled_at'           => now(),
                'grade'                 => null,
                'attendance_percentage' => 88.0,
                'status'                => 'enrolled',
            ]);
            $course->increment('students_count');
        }

        $this->command->info('  ✅ Demo enrollments created.');

        // ──────────────────────────────────────────────
        // 4. DEMO PAYMENTS
        // ──────────────────────────────────────────────
        Payment::create([
            'student_id'       => $gado->id,
            'reference_number' => 'UM-20250101-ABC001',
            'amount'           => 5000.00,
            'type'             => 'tuition',
            'method'           => 'gcash',
            'description'      => 'Tuition payment via GCash',
            'status'           => 'completed',
            'paid_at'          => now()->subDays(10),
        ]);

        Payment::create([
            'student_id'       => $gado->id,
            'reference_number' => 'UM-20250102-ABC002',
            'amount'           => 5000.00,
            'type'             => 'scholarship_credit',
            'method'           => 'scholarship',
            'description'      => 'Academic Scholarship Credit',
            'status'           => 'completed',
            'paid_at'          => now()->subDays(30),
        ]);

        $this->command->info('  ✅ Demo payments created.');

        // ──────────────────────────────────────────────
        // 5. WELCOME MESSAGES
        // ──────────────────────────────────────────────
        foreach ($createdStudents as $student) {
            Message::create([
                'sender_id'      => $student->id,
                'receiver_email' => $student->email,
                'subject'        => 'Welcome to UM Academic Portal!',
                'body'           => "Dear {$student->full_name},\n\nWelcome to the University of Mindanao Academic Portal (Tagum Campus).\n\n"
                                  . "Your Student ID: {$student->student_number}\n"
                                  . "Program: {$student->program}\n"
                                  . "Year Level: {$student->year_level}\n\n"
                                  . "Please enroll in your courses and keep track of your grades and attendance.\n\n"
                                  . "— UM Registrar Office",
                'type'           => 'welcome',
                'is_read'        => false,
            ]);
        }

        $this->command->info('  ✅ Welcome messages created.');

        // ──────────────────────────────────────────────
        $this->command->info('');
        $this->command->info('🎓 UM Portal seeding complete!');
        $this->command->info('');
        $this->command->info('   Demo Logins:');
        $this->command->info('   ┌──────────────────────────────────────────────────────┐');
        $this->command->info('   │  Student ID   │  Email                │  Password    │');
        $this->command->info('   ├──────────────────────────────────────────────────────┤');
        $this->command->info('   │  22-00001     │  gado@um.edu.ph       │  password123 │');
        $this->command->info('   │  22-00002     │  maria.santos@um.edu.ph│  password123 │');
        $this->command->info('   │  23-00010     │  juan.delacruz@um.edu.ph│  password123│');
        $this->command->info('   └──────────────────────────────────────────────────────┘');
        $this->command->info('');
    }
}