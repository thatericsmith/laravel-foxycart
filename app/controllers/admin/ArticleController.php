<?php namespace Admin;

use Article,Config,Exception,Input,Log,Redirect,Response,Topic,View;

class ArticleController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$view_args['articles'] = Article::orderBy('id','DESC')->get();
		return View::make('admin.article.index')->with($view_args);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('admin.article.create');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		// if we only got the topic id and url - send it to embedly
		$urls = Input::get('urls');
		$topic_id = Input::get('topic_id');
		$topic_title = Input::get('topic_title');
		$content = Input::get('content');
		$error = 'Invalid URL';

		// should we create a new topic?
		if(empty($topic_id) && !empty($topic_title)):
			// do we have this topic saved in the db already?
			$topic = Topic::where('title',$topic_title)->first();
			if(!isset($topic->id)):
				$topic = new Topic;
				$topic->title = $topic_title;
				$topic->save();
			endif;
		endif;

		$urls = array_filter($urls,'strlen'); // filter out empty values
		$urls = array_map('urlencode', $urls); // encode each url
		if(!empty($urls)):
			try{
				// article added to a valid topic?
				if(!isset($topic)):
					$topic = Topic::findOrFail($topic_id);
				endif;

				if(empty($content)):

					$api_key = Config::get('app.embedly_key');
					// ask service for content
					$api_url = 'http://api.embed.ly/1/extract?key='.$api_key.'&urls='.implode(',',$urls).'&format=json';
		            $curl = curl_init($api_url);
		            curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
		            $outputs = curl_exec($curl);
		            curl_close($curl);
		            $outputs = json_decode($outputs,true); // assoc array
		            if(!empty($outputs)):

		            	foreach($outputs as $output):
			            	if(isset($output['content']) && isset($output['title']) && isset($output['url'])):
			            		$url_exists = Article::where('url',$output['url'])->count();
				            	if(!$url_exists):
					            	$article = new Article;
					            	$article->url = $output['url'];
					            	$article->title = $output['title'];
					            	$article->content = $output['content'];
					            	$article->source = isset($output['provider_name']) ? $output['provider_name'] : null;
					            	$article->author = isset($output['authors'][0]['name']) ? $output['authors'][0]['name'] : null;
					            	$article->published = isset($output['published']) ? strtotime($output['published']) : null;
					            	# Account for date offset!
					            	
					            	if(!empty($output['images'][0]['url'])):
					            		$cloud_image = \Cloudinary\Uploader::upload($output['images'][0]['url']);
					            		if(!empty($cloud_image['public_id'])):
					            			$article->image = $cloud_image['public_id'];
					            		endif;
					            	endif;
					            	$article->topic_id = $topic->id;

					            	$article->save();
					            	unset($error);
					            	unset($article);
					            else:
					            	$error = 'URL found in DB already';
					            endif;
					        endif;
			            endforeach;
			        else:
			        	$error = 'API error or no content found '.$output;
		            endif;

				endif;
			}
			catch(Exception $e){
				$error = 'Topic not found';
			}

		endif;
		if(isset($error)):
			//Log::error($error);
		endif;
		
		$view = Input::get('view');
		if(isset($topic->id) && isset($view) && $view == 'topic'):
			return Redirect::route('admin.topic.edit',$topic->id);
		endif;
		return Redirect::route('admin.index');
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$view_args = [];
		$view_args['article'] = Article::find($id);
		return View::make('admin.article.edit')->with($view_args);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$article = Article::find($id);
		$article->grades()->delete();
		$article->delete();
		return Redirect::route('admin.article.index');
	}


}
