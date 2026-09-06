import React, { useState } from 'react';
import { PageRoute, Post } from '../types';
import { sidebarLatestNews } from '../data/mockData';

interface TinKhoaPageProps {
  posts: Post[];
  onNavigate: (route: PageRoute, param?: string) => void;
}

export const TinKhoaPage: React.FC<TinKhoaPageProps> = ({ posts, onNavigate }) => {
  const [currentPage, setCurrentPage] = useState(1);

  // Filter posts for "tin-khoa"
  const facultyNews = posts.filter((p) => p.category === 'tin-khoa');

  return (
    <div className="max-w-[1200px] mx-auto px-4 py-6">
      {/* Breadcrumb */}
      <div className="text-xs text-stone-500 mb-3">
        <button onClick={() => onNavigate('home')} className="hover:underline text-stone-600">
          Trang chủ
        </button>{' '}
        / <span className="text-[#7A2E25] font-semibold">Tin khoa</span>
      </div>

      {/* Header */}
      <div className="mb-6">
        <h1 className="text-3xl font-extrabold text-[#4A3028] tracking-tight uppercase mb-1">
          TIN KHOA
        </h1>
        <p className="text-xs text-stone-600">
          Cập nhật những thông tin, hoạt động và thông báo mới nhất từ khoa dành cho sinh viên.
        </p>
      </div>

      <div className="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        {/* Main content: Left 8 cols */}
        <div className="lg:col-span-8 space-y-4">
          {facultyNews.map((post) => {
            return (
              <article
                key={post.id}
                onClick={() => onNavigate('chi-tiet-bai-viet', post.id)}
                className="bg-white rounded-xl border border-[#E3D8CE] p-4 flex flex-col sm:flex-row gap-4 items-center shadow-2xs hover:shadow-md transition-all cursor-pointer group"
              >
                <div className="w-full sm:w-[220px] h-[130px] rounded-lg overflow-hidden shrink-0 bg-stone-100">
                  <img
                    src={post.image}
                    alt={post.title}
                    className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                  />
                </div>

                <div className="flex-1 flex flex-col justify-between min-h-[130px] w-full">
                  <div>
                    <h2 className="font-bold text-[15px] sm:text-base text-[#4A3028] leading-snug group-hover:text-[#7A2E25] transition-colors mb-2">
                      {post.title}
                    </h2>
                    <p className="text-xs text-stone-500 line-clamp-3 leading-relaxed">
                      {post.excerpt}
                    </p>
                  </div>

                  <div className="flex items-center justify-between mt-3 pt-2 text-[11px] text-stone-400 border-t border-stone-100">
                    <span>{post.date} &nbsp;•&nbsp; {post.views || 320} lượt xem</span>
                    <span className="font-semibold text-xs text-[#8F5326] group-hover:text-[#7A2E25] group-hover:underline">
                      Xem bài →
                    </span>
                  </div>
                </div>
              </article>
            );
          })}

          {/* Pagination */}
          <div className="flex items-center justify-center gap-1.5 pt-6 pb-2">
            <button
              onClick={() => setCurrentPage(Math.max(1, currentPage - 1))}
              className="w-7 h-7 flex items-center justify-center border border-[#7A2E25] text-[#7A2E25] rounded text-xs hover:bg-[#FFF2EA] cursor-pointer"
            >
              &lt;
            </button>
            {[1, 2, 3, 4, 5].map((page) => (
              <button
                key={page}
                onClick={() => setCurrentPage(page)}
                className={`w-7 h-7 flex items-center justify-center rounded text-xs font-semibold cursor-pointer transition ${
                  currentPage === page
                    ? 'bg-[#7A2E25] text-white shadow-xs'
                    : 'border border-[#7A2E25] text-[#4A3028] hover:bg-[#FFF2EA]'
                }`}
              >
                {page}
              </button>
            ))}
            <button
              onClick={() => setCurrentPage(Math.min(5, currentPage + 1))}
              className="w-7 h-7 flex items-center justify-center border border-[#7A2E25] text-[#7A2E25] rounded text-xs hover:bg-[#FFF2EA] cursor-pointer"
            >
              &gt;
            </button>
          </div>
        </div>

        {/* Sidebar: Right 4 cols */}
        <div className="lg:col-span-4 space-y-5">
          {/* DANH MỤC */}
          <div className="bg-white rounded-xl border border-[#7A2E25]/60 p-4 shadow-2xs">
            <h3 className="text-xs font-bold text-[#4A3028] uppercase tracking-wider mb-3 pb-2 border-b border-stone-100">
              DANH MỤC
            </h3>
            <ul className="space-y-2 text-xs">
              <li>
                <button
                  onClick={() => onNavigate('tin-khoa')}
                  className="font-bold text-[#7A2E25] text-left hover:underline flex items-center gap-1.5"
                >
                  <span className="w-1.5 h-1.5 rounded-full bg-[#7A2E25]"></span>
                  Tin khoa
                </button>
              </li>
              <li>
                <button
                  onClick={() => onNavigate('hoc-tap')}
                  className="text-stone-600 hover:text-[#7A2E25] text-left hover:underline"
                >
                  Học tập & Nghiên cứu
                </button>
              </li>
              <li>
                <button
                  onClick={() => onNavigate('co-hoi')}
                  className="text-stone-600 hover:text-[#7A2E25] text-left hover:underline"
                >
                  Cơ hội
                </button>
              </li>
              <li>
                <button
                  onClick={() => onNavigate('su-kien')}
                  className="text-stone-600 hover:text-[#7A2E25] text-left hover:underline"
                >
                  Sự kiện
                </button>
              </li>
              <li>
                <button
                  onClick={() => onNavigate('chi-tiet-thay-doi', 'thay-doi-hoi-thao-nckh')}
                  className="text-stone-600 hover:text-[#7A2E25] text-left hover:underline"
                >
                  Thông tin thay đổi
                </button>
              </li>
            </ul>
          </div>

          {/* BÀI MỚI NHẤT */}
          <div className="bg-white rounded-xl border border-[#E3D8CE] p-4 shadow-2xs">
            <h3 className="text-xs font-bold text-[#7A2E25] uppercase tracking-wider mb-3 pb-2 border-b border-stone-100">
              BÀI MỚI NHẤT
            </h3>
            <div className="space-y-3">
              {sidebarLatestNews.map((item) => (
                <div
                  key={item.id}
                  onClick={() => onNavigate('chi-tiet-bai-viet', item.id)}
                  className="flex items-center gap-3 cursor-pointer group"
                >
                  <div className="w-14 h-11 rounded-md overflow-hidden shrink-0 bg-stone-100">
                    <img
                      src={item.image}
                      alt={item.title}
                      className="w-full h-full object-cover group-hover:scale-105 transition-transform"
                    />
                  </div>
                  <div>
                    <h4 className="text-xs font-semibold text-[#4A3028] leading-tight group-hover:text-[#7A2E25] transition-colors line-clamp-2">
                      {item.title}
                    </h4>
                    <span className="text-[10px] text-stone-400 mt-0.5 block">{item.date}</span>
                  </div>
                </div>
              ))}
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};
