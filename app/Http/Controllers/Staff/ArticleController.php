<?php
/**
 * NOTICE OF LICENSE.
 *
 * UNIT3D is open-sourced software licensed under the GNU Affero General Public License v3.0
 * The details is bundled with this project in the file LICENSE.txt.
 *
 * @project    UNIT3D
 *
 * @license    https://www.gnu.org/licenses/agpl-3.0.en.html/ GNU Affero General Public License v3.0
 * @author     HDVinnie
 */

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Image;

class ArticleController extends Controller
{
    /**
     * Display All Articles.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $articles = Article::latest()->paginate(25);

        return view('Staff.article.index', ['articles' => $articles]);
    }

    /**
     * Article Add Form.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('Staff.article.create');
    }

    /**
     * Store A New Article.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $article = new Article();
        $article->title = $request->input('title');
        $article->slug = Str::slug($article->title);
        $article->content = $request->input('content');
        $article->user_id = $request->user()->id;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = 'article-'.uniqid().'.'.$image->getClientOriginalExtension();
            $path = public_path('/files/img/'.$filename);
            Image::make($image->getRealPath())->fit(75, 75)->encode('png', 100)->save($path);
            $article->image = $filename;
        } else {
            // Use Default /public/img/missing-image.png
            $article->image = null;
        }

        $v = validator($article->toArray(), [
            'title'   => 'required',
            'slug'    => 'required',
            'content' => 'required|min:20',
            'user_id' => 'required',
        ]);

        if ($v->fails()) {
            return redirect()->route('staff.articles.index')
                ->withErrors($v->errors());
        } else {
            $article->save();

            return redirect()->route('staff.articles.index')
                ->withSuccess('Your article has successfully published!');
        }
    }

    /**
     * Article Edit Form.
     *
     * @param $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $article = Article::findOrFail($id);

        return view('Staff.article.edit', ['article' => $article]);
    }

    /**
     * Edit A Article.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param                            $id
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $article = Article::findOrFail($id);
        $article->title = $request->input('title');
        $article->slug = Str::slug($article->title);
        $article->content = $request->input('content');

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = 'article-'.uniqid().'.'.$image->getClientOriginalExtension();
            $path = public_path('/files/img/'.$filename);
            Image::make($image->getRealPath())->fit(75, 75)->encode('png', 100)->save($path);
            $article->image = $filename;
        } else {
            // Use Default /public/img/missing-image.png
            $article->image = null;
        }

        $v = validator($article->toArray(), [
            'title'   => 'required',
            'slug'    => 'required',
            'content' => 'required|min:20',
        ]);

        if ($v->fails()) {
            return redirect()->route('staff.articles.index')
                ->withErrors($v->errors());
        } else {
            $article->save();

            return redirect()->route('staff.articles.index')
                ->withSuccess('Your article changes have successfully published!');
        }
    }

    /**
     * Delete A Article.
     *
     * @param $id
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        $article->delete();

        return redirect()->route('staff.articles.index')
            ->withSuccess('Article has successfully been deleted');
    }
}
