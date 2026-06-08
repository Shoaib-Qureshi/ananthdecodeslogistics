<?php

namespace App\Support;

use App\Models\BlogCategories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class ArticleCategories
{
    public const TRANSPORT_LOGISTICS = 'transport-logistics';
    public const OTHER = 'other';

    public static function selectable()
    {
        $columns = self::columns();

        if (!$columns) {
            return collect([]);
        }

        self::ensure(self::TRANSPORT_LOGISTICS, 'Transport & Logistics');

        return BlogCategories::whereIn($columns['slug'], [self::TRANSPORT_LOGISTICS])->get();
    }

    public static function resolveFromRequest(Request $request): BlogCategories
    {
        $choice = $request->input('category_choice', self::TRANSPORT_LOGISTICS);

        if ($choice === self::OTHER) {
            return self::ensureFromName($request->input('other_category'));
        }

        return self::ensure(self::TRANSPORT_LOGISTICS, 'Transport & Logistics');
    }

    public static function choiceFor(?BlogCategories $category): string
    {
        if (!$category || !self::columns()) {
            return self::TRANSPORT_LOGISTICS;
        }

        return self::slugValue($category) === self::TRANSPORT_LOGISTICS
            ? self::TRANSPORT_LOGISTICS
            : self::OTHER;
    }

    public static function nameFor(?BlogCategories $category): string
    {
        return $category && self::columns() ? self::nameValue($category) : '';
    }

    public static function validationRules(): array
    {
        return [
            'category_choice' => 'required|in:' . self::TRANSPORT_LOGISTICS . ',' . self::OTHER,
            'other_category' => 'required_if:category_choice,' . self::OTHER . '|nullable|string|max:255',
        ];
    }

    private static function ensureFromName(?string $name): BlogCategories
    {
        $name = trim((string) $name);
        $slug = Str::slug($name);

        abort_if($name === '' || $slug === '', 422, 'Please enter a valid category name.');

        return self::ensure($slug, $name);
    }

    private static function ensure(string $slug, string $name): BlogCategories
    {
        $columns = self::columns();

        abort_if(!$columns, 500, 'Article category columns are missing.');

        $category = BlogCategories::query()
            ->where(function ($query) use ($slug) {
                foreach (self::slugColumns() as $index => $column) {
                    $method = $index === 0 ? 'where' : 'orWhere';
                    $query->{$method}($column, $slug);
                }
            })
            ->first();

        if (!$category) {
            $category = new BlogCategories();
        }

        $category->fill(self::categoryAttributes($slug, $name));
        $category->save();

        return $category;
    }

    private static function columns(): ?array
    {
        $slugColumn = Schema::hasColumn('blog_category', 'category_slug')
            ? 'category_slug'
            : (Schema::hasColumn('blog_category', 'slug') ? 'slug' : null);
        $nameColumn = Schema::hasColumn('blog_category', 'category_name')
            ? 'category_name'
            : (Schema::hasColumn('blog_category', 'name') ? 'name' : null);

        if (is_null($slugColumn) || is_null($nameColumn)) {
            return null;
        }

        return [
            'slug' => $slugColumn,
            'name' => $nameColumn,
        ];
    }

    private static function categoryAttributes(string $slug, string $name): array
    {
        $attributes = [];

        foreach (['category_name', 'name'] as $column) {
            if (Schema::hasColumn('blog_category', $column)) {
                $attributes[$column] = $name;
            }
        }

        foreach (['category_slug', 'slug'] as $column) {
            if (Schema::hasColumn('blog_category', $column)) {
                $attributes[$column] = $slug;
            }
        }

        return $attributes;
    }

    private static function slugColumns(): array
    {
        return array_values(array_filter(
            ['category_slug', 'slug'],
            static fn (string $column): bool => Schema::hasColumn('blog_category', $column)
        ));
    }

    private static function slugValue(BlogCategories $category): string
    {
        foreach (self::slugColumns() as $column) {
            if (!empty($category->{$column})) {
                return (string) $category->{$column};
            }
        }

        return '';
    }

    private static function nameValue(BlogCategories $category): string
    {
        foreach (['category_name', 'name'] as $column) {
            if (Schema::hasColumn('blog_category', $column) && !empty($category->{$column})) {
                return (string) $category->{$column};
            }
        }

        return '';
    }
}
