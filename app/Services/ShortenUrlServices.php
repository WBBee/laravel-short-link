<?php

namespace App\Services;

use App\Models\PerClick;
use App\Models\ShortLink;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\DocBlock\Tags\Return_;
use Symfony\Component\Console\Input\Input;

class ShortenUrlServices
{
    public function get_my_links($user)
    {
        return ShortLink::query()
            ->withCount(['perclicks'])
            ->where('user_id', '=', $user->id)
            ->get();
    }

    public function short_my_link($user, string $long_url)
    {
        DB::beginTransaction();
        try {
            $create_short_link = new ShortLink([
                'shorten_url' => Str::random(8),
                'destination_url' => $long_url
            ]);
            $user->create_short_link()->save($create_short_link);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function update_my_link(array $input)
    {
        DB::beginTransaction();

        try {
            ShortLink::query()
                ->where('id', '=', $input['id'])
                ->update($input);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function add_perclick(string $shorten_url)
    {

        DB::beginTransaction();

        try {
            $link = ShortLink::query()
                ->where('shorten_url', $shorten_url)
                ->first();

            $per_click = new PerClick();
            $link->perclick()->save($per_click);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }

        return $link->destination_url;
    }
}
