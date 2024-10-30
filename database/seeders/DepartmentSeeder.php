<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Department;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            'Khoa Toán - Tin' => [
                'Đại số tuyến tính',
                'Giải tích 1',
                'Lập trình C++',
            ],
            'Khoa Vật lý' => [
                'Cơ học lượng tử',
                'Điện động lực học',
                'Vật lý nhiệt',
            ],
            'Khoa Hóa học' => [
                'Hóa hữu cơ',
                'Hóa vô cơ',
                'Phản ứng hóa học',
            ],
            'Khoa Sinh học' => [
                'Di truyền học',
                'Sinh thái học',
                'Sinh lý học người',
            ],
            'Khoa Ngữ văn' => [
                'Văn học hiện đại',
                'Ngữ pháp tiếng Việt',
                'Phương pháp giảng dạy văn',
            ],
            'Khoa Lịch sử' => [
                'Lịch sử Việt Nam',
                'Lịch sử thế giới',
                'Phương pháp nghiên cứu lịch sử',
            ],
            'Khoa Địa lý' => [
                'Địa lý kinh tế',
                'Địa lý tự nhiên',
                'Bản đồ học',
            ],
            'Khoa Tâm lý - Giáo dục' => [
                'Tâm lý học giáo dục',
                'Phương pháp giảng dạy',
                'Quản lý lớp học',
            ],
            'Khoa Giáo dục Tiểu học' => [
                'Phương pháp dạy Toán tiểu học',
                'Phương pháp dạy Tiếng Việt tiểu học',
                'Phát triển kỹ năng giảng dạy',
            ],
            'Khoa Giáo dục Mầm non' => [
                'Tâm lý trẻ em',
                'Phát triển ngôn ngữ cho trẻ',
                'Hoạt động vui chơi giáo dục',
            ],
            'Khoa Công nghệ Thông tin' => [
                'Lập trình Web',
                'Cơ sở dữ liệu',
                'Khoa học máy tính',
            ],
            'Khoa Giáo dục Đặc biệt' => [
                'Giáo dục trẻ tự kỷ',
                'Phương pháp giáo dục trẻ khuyết tật',
                'Tâm lý trẻ em đặc biệt',
            ],
            'Khoa Kinh tế và Quản lý' => [
                'Quản trị kinh doanh',
                'Kinh tế học vi mô',
                'Marketing căn bản',
            ],
            'Khoa Giáo dục Chính trị' => [
                'Chính trị học đại cương',
                'Tư tưởng Hồ Chí Minh',
                'Giáo dục công dân',
            ],
            'Khoa Giáo dục Quốc phòng' => [
                'Kỹ thuật quân sự',
                'Pháp luật quân sự',
                'Quản lý quốc phòng',
            ],
            'Khoa Giáo dục Thể chất' => [
                'Giáo dục thể chất',
                'Phương pháp huấn luyện thể thao',
                'Sinh lý thể thao',
            ],
            'Khoa Tiếng Anh' => [
                'Ngữ âm và phát âm',
                'Kỹ năng giao tiếp tiếng Anh',
                'Văn học Anh',
            ],
            'Khoa Tiếng Pháp' => [
                'Ngữ pháp tiếng Pháp',
                'Giao tiếp tiếng Pháp',
                'Văn học Pháp',
            ],
            'Khoa Tiếng Trung' => [
                'Ngữ pháp tiếng Trung',
                'Phiên dịch tiếng Trung',
                'Kỹ năng giao tiếp tiếng Trung',
            ],
            'Khoa Tiếng Nhật' => [
                'Ngữ pháp tiếng Nhật',
                'Kỹ năng giao tiếp tiếng Nhật',
                'Văn học Nhật Bản',
            ],
        ];

        foreach ($departments as $key => $item) {
            $department = Department::create([
                'name' => $key,
                'slug' => Str::slug($key),
            ]);

            foreach ($item as $key2 => $courseName) {
                Course::create([
                    'name' => $courseName,
                    'slug' => Str::slug($courseName),
                    'memeber_count' => fake()->numberBetween(40, 100),
                    'department_id' => $department->id,
                ]);
            }
        }
    }
}
