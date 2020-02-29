<?php
namespace App\Services;

class Slug
{
    /**
     * @param $m9del
     * @param $title
     * @param int $id
     * @return string
     * @throws \Exception
     */
    public static function make($model, $title, $id = 0)
    {
        // Normalize the title
        $slug = str_slug($title);
        // Get any that could possibly be related.
        // This cuts the queries down by doing it once
        $allSlugs = self::getRelatedSlugs($model, $slug, $id);
        // If we haven't used it before then we are all good.
        if (! $allSlugs->contains('slug', $slug)){
            return $slug;
        }
        // Just append numbers like a savage until we find not used.
        for ($i = 1; $i <= 10; $i++) {
            $newSlug = $slug.'-'.$i;
            if (! $allSlugs->contains('slug', $newSlug)) {
                return $newSlug;
            }
        }
        throw new \Exception('Can not create a unique slug');
    }


    protected static function getRelatedSlugs($model, $slug, $id = 0)
    {
        return $model->select('slug')->where('slug', 'like', $slug.'%')
            ->where('id', '<>', $id)
            ->get();

    }
}