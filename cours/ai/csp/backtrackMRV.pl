backtrackMRV(Assignment) :-
    variables(Variables),                                                     % get the predefined variables
    forwardcheckingMRV(Variables,[],Assignment).                              % solve the problem and get an solution assignment

forwardcheckingMRV([],_,[]).
forwardcheckingMRV(Variables,PartialAssignment,[(X,V)|Solution]) :-
    findMRV(Variables,X:DX,VariablesWithoutX),                                % find the MRV variable V
    member(V,DX),                                                             % choose a value in the V's domain
    filter(X,V,VariablesWithoutX,FilteredVariables),                          % filter variables' domains
    forwardcheckingMRV(FilteredVariables,[(X,V)|PartialAssignment],Solution). % add the V's assignment to the partial one

filter(_,_,[],[]).
filter(Xi,Vi,[Xj:Dj|Variables],[Xj:FilteredDj|FilteredDomains]) :-
    bagof(Vj, (member(Vj,Dj),consistent((Xi,Vi),(Xj,Vj))), FilteredDj),       % get the values for variables sharing constraints
    FilteredDj \= [],                                                         % stop if no more values
    filter(Xi,Vi,Variables,FilteredDomains).                                  % continue on next variables

findMRV([X:DX|Variables],Xmin:DXmin,VariablesWithoutXmin) :-
    length(DX,N),                                                     % set the first minimum to the length of the first domain
    findMRV_aux(Variables,X:DX,N,Xmin:DXmin,VariablesWithoutXmin).    % search

findMRV_aux([],X:DX,_,X:DX,[]).                                       % there is no more variable to look at
findMRV_aux([X:DX|Variables],Y:DY,N,Z:DZ,[Y:DY|VariablesWithoutZ]) :- % another variable has a smaller domain
    length(DX,M),
    M<N, !,
    findMRV_aux(Variables,X:DX,M,Z:DZ,VariablesWithoutZ).
findMRV_aux([X:DX|Variables],Y:DY,N,Z:DZ,[X:DX|VariablesWithoutZ]) :- % the current variable has the smaller domain
    findMRV_aux(Variables,Y:DY,N,Z:DZ,VariablesWithoutZ).
