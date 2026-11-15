<?php

namespace SamuelOlavo\LaravelXibo\Resources;

/** Generated resource accessors. */
trait ResourceAccessors
{
    public function action(): ActionResource
    {
        return new ActionResource($this);
    }

    public function campaign(): CampaignResource
    {
        return new CampaignResource($this);
    }

    public function command(): CommandResource
    {
        return new CommandResource($this);
    }

    public function dataset(): DatasetResource
    {
        return new DatasetResource($this);
    }

    public function dayPart(): DayPartResource
    {
        return new DayPartResource($this);
    }

    public function display(): DisplayResource
    {
        return new DisplayResource($this);
    }

    public function displayGroup(): DisplayGroupResource
    {
        return new DisplayGroupResource($this);
    }

    public function displayVenue(): DisplayVenueResource
    {
        return new DisplayVenueResource($this);
    }

    public function displayprofile(): DisplayprofileResource
    {
        return new DisplayprofileResource($this);
    }

    public function folder(): FolderResource
    {
        return new FolderResource($this);
    }

    public function font(): FontResource
    {
        return new FontResource($this);
    }

    public function layout(): LayoutResource
    {
        return new LayoutResource($this);
    }

    public function library(): LibraryResource
    {
        return new LibraryResource($this);
    }

    public function menuBoard(): MenuBoardResource
    {
        return new MenuBoardResource($this);
    }

    public function misc(): MiscResource
    {
        return new MiscResource($this);
    }

    public function module(): ModuleResource
    {
        return new ModuleResource($this);
    }

    public function notification(): NotificationResource
    {
        return new NotificationResource($this);
    }

    public function playerSoftware(): PlayerSoftwareResource
    {
        return new PlayerSoftwareResource($this);
    }

    public function playlist(): PlaylistResource
    {
        return new PlaylistResource($this);
    }

    public function resolution(): ResolutionResource
    {
        return new ResolutionResource($this);
    }

    public function schedule(): ScheduleResource
    {
        return new ScheduleResource($this);
    }

    public function session(): SessionResource
    {
        return new SessionResource($this);
    }

    public function statistics(): StatisticsResource
    {
        return new StatisticsResource($this);
    }

    public function syncGroup(): SyncGroupResource
    {
        return new SyncGroupResource($this);
    }

    public function tags(): TagsResource
    {
        return new TagsResource($this);
    }

    public function template(): TemplateResource
    {
        return new TemplateResource($this);
    }

    public function user(): UserResource
    {
        return new UserResource($this);
    }

    public function usergroup(): UsergroupResource
    {
        return new UsergroupResource($this);
    }

    public function widget(): WidgetResource
    {
        return new WidgetResource($this);
    }

}
